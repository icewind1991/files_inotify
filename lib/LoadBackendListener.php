<?php

declare(strict_types=1);
/**
 * @copyright Copyright (c) 2021 Robin Appelman <robin@icewind.nl>
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

namespace OCA\FilesInotify\lib;

use OCA\Files_External\Service\BackendService;
use OCA\Files_INotify\INotifyBackendProvider;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;

/**
 * @template-implements IEventListener<Event>
 */
class LoadBackendListener implements IEventListener {
	private BackendService $backendService;
	private INotifyBackendProvider $backendProvider;

	public function __construct(BackendService $backendService, INotifyBackendProvider $backendProvider) {
		$this->backendService = $backendService;
		$this->backendProvider = $backendProvider;
	}

	public function handle(Event $event): void {
		if (\OC::$CLI) {
			$this->backendService->registerBackendProvider($this->backendProvider);
		}
	}
}
