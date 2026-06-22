<?php

/**
 * SPDX-FileCopyrightText: 2017-2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-FileCopyrightText: 2016 ownCloud, Inc.
 * SPDX-License-Identifier: AGPL-3.0-only
 */

namespace OCA\Files_External\Lib;

/**
 * Trait for objects requiring an identifier (and/or identifier aliases)
 * Also supports deprecation to a different object, linking the objects
 */
trait IdentifierTrait {

	protected string $identifier = '';

	/** @var string[] */
	protected array $identifierAliases = [];
	protected ?IIdentifier $deprecateTo = null;

	public function getIdentifier(): string
    {
    }

	public function setIdentifier(string $identifier): self
    {
    }

	/**
	 * @return string[]
	 */
	public function getIdentifierAliases(): array
    {
    }

	public function addIdentifierAlias(string $alias): self
    {
    }

	public function getDeprecateTo(): ?IIdentifier
    {
    }

	public function deprecateTo(IIdentifier $destinationObject): self
    {
    }

	public function jsonSerializeIdentifier(): array
    {
    }
}
