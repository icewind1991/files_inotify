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

namespace OCA\Files_INotify\AppInfo;

use OCA\Files_External\Lib\Config\IBackendProvider;
use OCA\Files_External\Service\BackendService;
use OCA\Files_INotify\Storage\INotifyBackend;
use \OCP\AppFramework\App;

class Application extends App implements IBackendProvider {
	public function __construct(array $urlParams = []) {
		parent::__construct('files_inotify', $urlParams);
	}

	public function register() {
		if (\OC::$CLI) {
			/** @var \OC\Server $server */
			$server = $this->getContainer()->getServer();

			/** @var BackendService $backendService */
			$backendService = $server->query(BackendService::class);

			$backendService->registerBackendProvider($this);
		}
	}

	public function getBackends() {
		$container = $this->getContainer();

		return [
			$container->query(INotifyBackend::class)
		];
	}
}
