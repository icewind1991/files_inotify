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

namespace OCP\Files\Notify {
	interface INotifyHandler {
	}

	interface IChange {
		const ADDED = 1;
		const REMOVED = 2;
		const MODIFIED = 3;
		const RENAMED = 4;
	}

	interface IRenameChange extends IChange {
	}
}

namespace OC\Files\Notify {

	use OCP\Files\Notify\IChange;
	use OCP\Files\Notify\IRenameChange;

	class Change implements IChange {
		/** @var int */
		private $type;

		/** @var string */
		private $path;

		public function __construct($type, $path) {
			$this->type = $type;
			$this->path = $path;
		}

		public function getType() {
			return $this->type;
		}

		public function getPath() {
			return $this->path;
		}
	}

	class RenameChange extends Change implements IRenameChange {
		/** @var string */
		private $targetPath;

		public function __construct($type, $path, $targetPath) {
			parent::__construct($type, $path);
			$this->targetPath = $targetPath;
		}

		public function getTargetPath() {
			return $this->targetPath;
		}
	}
}
