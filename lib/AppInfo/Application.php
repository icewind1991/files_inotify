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

use OCA\Files_External\Service\BackendService;
use OCA\Files_INotify\INotifyBackendProvider;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\IAppContainer;
use OCP\EventDispatcher\IEventDispatcher;

class Application extends App implements IBootstrap {
	public function __construct(array $urlParams = []) {
		parent::__construct('files_inotify', $urlParams);
	}

	public function register(IRegistrationContext $context): void {
	}

	public function boot(IBootContext $context): void {
		$context->injectFn([$this, 'registerBackendDependents']);
	}

	public function registerBackendDependents(IAppContainer $appContainer, IEventDispatcher $dispatcher) {
		$dispatcher->addListener(
			'OCA\\Files_External::loadAdditionalBackends',
			function () use ($appContainer) {
				if (\OC::$CLI && class_exists(BackendService::class)) {
					// we can't inject these 2, since they would cause hard errors if files_external is not enabled
					/** @var BackendService $backendService */
					$backendService = $appContainer->get(BackendService::class);
					/** @var INotifyBackendProvider $backendProvider */
					$backendProvider = $appContainer->get(INotifyBackendProvider::class);
					$backendService->registerBackendProvider($backendProvider);
				}
			}
		);
	}
}
