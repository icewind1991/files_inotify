<?php

/**
 * SPDX-FileCopyrightText: 2018-2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-FileCopyrightText: 2016 ownCloud, Inc.
 * SPDX-License-Identifier: AGPL-3.0-only
 */

namespace OCA\Files_External\Service;

use OC\Files\Storage\Common;
use OCA\Files_External\AppInfo\Application;
use OCA\Files_External\Config\IConfigHandler;
use OCA\Files_External\Config\UserContext;
use OCA\Files_External\ConfigLexicon;
use OCA\Files_External\Lib\Auth\AuthMechanism;
use OCA\Files_External\Lib\Backend\Backend;
use OCA\Files_External\Lib\Config\IAuthMechanismProvider;
use OCA\Files_External\Lib\Config\IBackendProvider;
use OCP\EventDispatcher\GenericEvent;
use OCP\EventDispatcher\IEventDispatcher;
use OCP\Files\StorageNotAvailableException;
use OCP\IAppConfig;
use OCP\Server;
use Psr\Container\ContainerExceptionInterface;
use Psr\Log\LoggerInterface;

/**
 * Service class to manage backend definitions
 */
class BackendService {

	/** Visibility constants for VisibilityTrait */
	public const VISIBILITY_NONE = 0;
	public const VISIBILITY_PERSONAL = 1;
	public const VISIBILITY_ADMIN = 2;
	//const VISIBILITY_ALIENS = 4;

	public const VISIBILITY_DEFAULT = 3; // PERSONAL | ADMIN

	/** Priority constants for PriorityTrait */
	public const PRIORITY_DEFAULT = 100;

	public function __construct(
		protected readonly IAppConfig $appConfig,
		private readonly LoggerInterface $logger,
	) {
	}

	/**
	 * Register a backend provider
	 *
	 * @since 9.1.0
	 * @param IBackendProvider $provider
	 */
	public function registerBackendProvider(IBackendProvider $provider)
    {
    }

	/**
	 * Register an auth mechanism provider
	 *
	 * @since 9.1.0
	 * @param IAuthMechanismProvider $provider
	 */
	public function registerAuthMechanismProvider(IAuthMechanismProvider $provider)
    {
    }

	/**
	 * Register a backend
	 *
	 * @deprecated 9.1.0 use registerBackendProvider()
	 * @param Backend $backend
	 */
	public function registerBackend(Backend $backend)
    {
    }

	/**
	 * @deprecated 9.1.0 use registerBackendProvider()
	 * @param Backend[] $backends
	 */
	public function registerBackends(array $backends)
    {
    }
	/**
	 * Register an authentication mechanism
	 *
	 * @deprecated 9.1.0 use registerAuthMechanismProvider()
	 * @param AuthMechanism $authMech
	 */
	public function registerAuthMechanism(AuthMechanism $authMech)
    {
    }

	/**
	 * @deprecated 9.1.0 use registerAuthMechanismProvider()
	 * @param AuthMechanism[] $mechanisms
	 */
	public function registerAuthMechanisms(array $mechanisms)
    {
    }

	/**
	 * Get all backends
	 *
	 * @return Backend[]
	 */
	public function getBackends()
    {
    }

	/**
	 * Get all available backends
	 *
	 * @return Backend[]
	 */
	public function getAvailableBackends()
    {
    }

	/**
	 * @param string $identifier
	 * @return Backend|null
	 */
	public function getBackend($identifier)
    {
    }

	/**
	 * Get all authentication mechanisms
	 *
	 * @return AuthMechanism[]
	 */
	public function getAuthMechanisms()
    {
    }

	/**
	 * Get all authentication mechanisms for schemes
	 *
	 * @param string[] $schemes
	 * @return AuthMechanism[]
	 */
	public function getAuthMechanismsByScheme(array $schemes)
    {
    }

	/**
	 * @param string $identifier
	 * @return AuthMechanism|null
	 */
	public function getAuthMechanism($identifier)
    {
    }

	/**
	 * returns if user mounting is allowed.
	 * also initiate the list of available backends.
	 *
	 * @psalm-assert bool $this->userMountingAllowed
	 */
	public function isUserMountingAllowed(): bool
    {
    }

	/**
	 * Check a backend if a user is allowed to mount it
	 *
	 * @param Backend $backend
	 * @return bool
	 */
	public function isAllowedUserBackend(Backend $backend): bool
    {
    }

	/**
	 * Check an authentication mechanism if a user is allowed to use it
	 *
	 * @param AuthMechanism $authMechanism
	 * @return bool
	 */
	protected function isAllowedAuthMechanism(AuthMechanism $authMechanism)
    {
    }

	/**
	 * registers a configuration handler
	 *
	 * The function of the provided $placeholder is mostly to act a sorting
	 * criteria, so longer placeholders are replaced first. This avoids
	 * "$user" overwriting parts of "$userMail" and "$userLang", for example.
	 * The provided value should not contain the $ prefix, only a-z0-9 are
	 * allowed. Upper case letters are lower cased, the replacement is case-
	 * insensitive.
	 *
	 * The configHandlerLoader should just instantiate the handler on demand.
	 * For now all handlers are instantiated when a mount is loaded, independent
	 * of whether the placeholder is present or not. This may change in future.
	 *
	 * @since 16.0.0
	 */
	public function registerConfigHandler(string $placeholder, callable $configHandlerLoader)
    {
    }

	protected function loadConfigHandlers(): void
    {
    }

	/**
	 * @since 16.0.0
	 * @return IConfigHandler[]
	 */
	public function getConfigHandlers(): array
    {
    }

	/**
	 * @param mixed $input
	 * @return mixed
	 * @throws ContainerExceptionInterface
	 */
	public function applyConfigHandlers($input, ?string $userId = null)
    {
    }

	/**
	 * Test connecting using the given backend configuration
	 *
	 * @param string $class backend class name
	 * @param array $options backend configuration options
	 * @return StorageNotAvailableException::STATUS_*
	 * @throws \Exception
	 */
	public function getBackendStatus(string $class, array $options): int
    {
    }
}
