<?php
/**
 * @copyright Copyright (c) 2020 Robin Appelman <robin@icewind.nl>
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

namespace OCA\Files_INotify\Tests\Storage;

use OC\Files\Notify\Change;
use OC\Files\Notify\RenameChange;
use OCA\Files_INotify\Storage\NotifyHandler;
use OCP\Files\Notify\IChange;
use Test\TestCase;

class NotifyHandlerTest extends TestCase {
	/** @var NotifyHandler */
	private $handler;
	/** @var string */
	private $basePath;

	protected function setUp(): void {
		parent::setUp();

		$this->basePath = \OC::$server->getTempManager()->getTemporaryFolder();
		$this->handler = new NotifyHandler($this->basePath);
	}

	public function testBasicNotify() {
		file_put_contents($this->basePath . 'foo.txt', 'foo');
		usleep(100 * 1000);

		$changes = $this->handler->getChanges();
		$this->assertEquals([new Change(IChange::ADDED, "foo.txt")], $changes);

		file_put_contents($this->basePath . 'foo.txt', 'bar');
		usleep(100 * 1000);

		$changes = $this->handler->getChanges();
		$this->assertEquals([new Change(IChange::MODIFIED, "foo.txt")], $changes);

		rename($this->basePath . 'foo.txt', $this->basePath . 'bar.txt');
		usleep(100 * 1000);

		$changes = $this->handler->getChanges();
		$this->assertEquals([new RenameChange(IChange::RENAMED, "foo.txt", "bar.txt")], $changes);

		unlink($this->basePath . 'bar.txt');
		usleep(100 * 1000);

		$changes = $this->handler->getChanges();
		$this->assertEquals([new Change(IChange::REMOVED, "bar.txt")], $changes);
	}
}
