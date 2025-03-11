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

use OC\Files\Storage\Local;
use OCP\Files\Notify\IChange;
use OCP\Files\Notify\IRenameChange;
use OCP\Files\Storage\INotifyStorage;

class INotifyWrapper extends Local implements INotifyStorage {
	public function listen($path, callable $callback) {
		$this->notify($path)->listen(function (IChange $change) use ($callback) {
			if ($change instanceof IRenameChange) {
				return $callback($change->getType(), $change->getPath(), $change->getTargetPath());
			} else {
				return $callback($change->getType(), $change->getPath());
			}
		});
	}

	public function notify($path) {
		return new NotifyHandler($this->datadir);
	}
}
