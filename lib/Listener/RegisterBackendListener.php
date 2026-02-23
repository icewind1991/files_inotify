<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2026 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */
namespace OCA\Files_INotify\Listener;

use OCA\Files_External\Service\BackendService;
use OCA\Files_INotify\INotifyBackendProvider;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\Group\Events\GroupDeletedEvent;

/** @template-implements IEventListener<GroupDeletedEvent> */
class RegisterBackendListener implements IEventListener {


	public function __construct(
		private readonly BackendService $backendService,
		private readonly INotifyBackendProvider $notifyProvider,
	) {
	}

	#[\Override]
	public function handle(Event $event): void {
		if (\OC::$CLI) {
			$this->backendService->registerBackendProvider($this->notifyProvider);
		}
	}

}
