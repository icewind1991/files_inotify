<?php

/**
 * SPDX-FileCopyrightText: 2019-2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-FileCopyrightText: 2016 ownCloud, Inc.
 * SPDX-License-Identifier: AGPL-3.0-only
 */

namespace OCA\Files_External\Lib;

use OCA\Files_External\Service\BackendService;

/**
 * Trait to implement visibility mechanics for a configuration class
 *
 * The standard visibility defines which users/groups can use or see the
 * object. The allowed visibility defines the maximum visibility allowed to be
 * set on the object. The standard visibility is often set dynamically by
 * stored configuration parameters that can be modified by the administrator,
 * while the allowed visibility is set directly by the object and cannot be
 * modified by the administrator.
 */
trait VisibilityTrait {

	/** @var int visibility */
	protected $visibility = BackendService::VISIBILITY_DEFAULT;

	/** @var int allowed visibilities */
	protected $allowedVisibility = BackendService::VISIBILITY_DEFAULT;

	/**
	 * @return int
	 */
	public function getVisibility()
    {
    }

	/**
	 * Check if the backend is visible for a user type
	 *
	 * @param int $visibility
	 * @return bool
	 */
	public function isVisibleFor($visibility)
    {
    }

	/**
	 * @param int $visibility
	 * @return self
	 */
	public function setVisibility($visibility)
    {
    }

	/**
	 * @param int $visibility
	 * @return self
	 */
	public function addVisibility($visibility)
    {
    }

	/**
	 * @param int $visibility
	 * @return self
	 */
	public function removeVisibility($visibility)
    {
    }

	/**
	 * @return int
	 */
	public function getAllowedVisibility()
    {
    }

	/**
	 * Check if the backend is allowed to be visible for a user type
	 *
	 * @param int $allowedVisibility
	 * @return bool
	 */
	public function isAllowedVisibleFor($allowedVisibility)
    {
    }

	/**
	 * @param int $allowedVisibility
	 * @return self
	 */
	public function setAllowedVisibility($allowedVisibility)
    {
    }

	/**
	 * @param int $allowedVisibility
	 * @return self
	 */
	public function addAllowedVisibility($allowedVisibility)
    {
    }

	/**
	 * @param int $allowedVisibility
	 * @return self
	 */
	public function removeAllowedVisibility($allowedVisibility)
    {
    }
}
