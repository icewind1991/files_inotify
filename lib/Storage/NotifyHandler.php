<?php
/**
 * @copyright Copyright (c) 2017 Robin Appelman <robin@icewind.nl>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\Files_INotify\Storage;

use OC\Files\Notify\Change;
use OC\Files\Notify\RenameChange;
use OCP\Files\Notify\IChange;
use OCP\Files\Notify\INotifyHandler;

class NotifyHandler implements INotifyHandler {
	/** @var resource */
	private $fd;

	/** @var string */
	private $basePath;

	private $pathMap = [];

	private $moveMap = [];

	/**
	 * @param string $basePath
	 */
	public function __construct($basePath) {
		$this->fd = inotify_init();

		$this->basePath = rtrim($basePath, '/');
		$this->register();
	}

	private function getDirectoryIterator($path) {
		return new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($path, \FilesystemIterator::CURRENT_AS_PATHNAME + \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST);
	}

	private function register() {
		$iterator = $this->getDirectoryIterator($this->basePath);

		$this->watchPath($this->basePath);
		foreach ($iterator as $path) {
			if (is_dir($path)) {
				$this->watchPath($path);
			}
		}
	}

	private function watchPath($path) {
		$descriptor = inotify_add_watch($this->fd, $path, \IN_MODIFY + \IN_CREATE + \IN_MOVED_FROM + \IN_MOVED_TO + \IN_DELETE);
		$this->pathMap[$descriptor] = $path;
	}

	public function getChanges() {

		stream_set_blocking($this->fd, false);
		return $this->readEvents();
	}

	/**
	 * @return IChange[]
	 */
	private function readEvents() {
		$events = inotify_read($this->fd);
		$parsedEvents = array_map([$this, 'parseEvent'], $events);
		return call_user_func_array('array_merge', $parsedEvents);
	}

	/**
	 * @param array $event
	 * @return IChange[]
	 * @throws \Exception
	 */
	private function parseEvent(array $event) {
		if (!isset($this->pathMap[$event['wd']])) {
			throw new \Exception('Invalid inotify event');
		}
		$path = $this->pathMap[$event['wd']] . '/' . $event['name'];

		$mask = $event['mask'];
		$cookie = $event['cookie'];
		if (($mask & \IN_MOVED_TO) || ($mask & \IN_MOVED_FROM)) {
			if (!isset($this->moveMap[$cookie])) {
				$this->moveMap[$cookie] = [];
			}
		}
		if ($mask & \IN_MOVED_FROM) {
			if (isset($this->moveMap[$cookie]['to'])) {
				$targetPath = $this->moveMap[$event['cookie']]['to'];
				unset($this->moveMap[$cookie]);
				return [new RenameChange(IChange::RENAMED, $this->getRelativePath($path), $this->getRelativePath($targetPath))];
			} else {
				$this->moveMap[$event['cookie']]['from'] = $path;
				return [];
			}
		}

		if ($mask & \IN_MOVED_TO) {
			if (isset($this->moveMap[$cookie]['from'])) {
				$fromPath = $this->moveMap[$event['cookie']]['from'];
				unset($this->moveMap[$cookie]);
				return [new RenameChange(IChange::RENAMED, $this->getRelativePath($fromPath), $this->getRelativePath($path))];
			} else {
				$this->moveMap[$event['cookie']]['to'] = $path;
				return [];
			}
		}

		if ($mask & \IN_MODIFY) {
			return [new Change(IChange::MODIFIED, $this->getRelativePath($path))];
		}
		if ($mask & \IN_CREATE) {
			if (is_dir($path . '/')) {
				$events = $this->createChildEvents($path);
				$this->watchPath($path);
			} else {
				$events = [];
			}
			array_unshift($events, new Change(IChange::ADDED, $this->getRelativePath($path)));
			return $events;
		}
		if ($mask & \IN_DELETE) {
			return [new Change(IChange::REMOVED, $this->getRelativePath($path))];
		}
		return [];
	}

	/**
	 * create "create changes" for files inside a newly detected directory
	 *
	 * this is needed since a file can be added to a directory before we have the time to add a watch
	 *
	 * @param $path
	 * @return IChange[]
	 */
	private function createChildEvents($path) {
		$changes = [];
		foreach ($this->getDirectoryIterator($path) as $file) {
			$changes[] = new Change(IChange::ADDED, $this->getRelativePath($file));
		}
		return $changes;
	}

	/**
	 * @param $path
	 * @return string
	 */
	private function getRelativePath($path) {
		return substr($path, strlen($this->basePath) + 1);
	}

	public function listen(callable $callback) {

		stream_set_blocking($this->fd, true);
		if (function_exists('pcntl_signal')) {
			pcntl_signal(SIGTERM, array($this, 'stop'));
			pcntl_signal(SIGINT, array($this, 'stop'));
		}
		$active = true;
		$read = [$this->fd];
		$write = null;
		$except = null;
		while ($active && is_resource($this->fd)) {
			$changed = stream_select($read, $write, $except, 60);
			if (function_exists('pcntl_signal_dispatch')) {
				pcntl_signal_dispatch();
			}

			if ($changed) {
				$events = $this->readEvents();
				foreach ($events as $event) {
					if ($callback($event) === false) {
						$active = false;
					}
				}
			}
		}
	}

	public function stop() {
		fclose($this->fd);
	}
}
