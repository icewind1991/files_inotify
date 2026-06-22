<?php

/**
 * SPDX-FileCopyrightText: 2017-2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-FileCopyrightText: 2016 ownCloud, Inc.
 * SPDX-License-Identifier: AGPL-3.0-only
 */

namespace OCA\Files_External\Lib;

/**
 * Trait for objects that have a frontend representation
 */
trait FrontendDefinitionTrait {

	public function getText(): string
    {
    }

	public function setText(string $text): self
    {
    }

	public static function lexicalCompare(IFrontendDefinition $a, IFrontendDefinition $b): int
    {
    }

	/**
	 * @return array<string, DefinitionParameter>
	 */
	public function getParameters(): array
    {
    }

	/**
	 * @param list<DefinitionParameter> $parameters
	 */
	public function addParameters(array $parameters): self
    {
    }

	public function addParameter(DefinitionParameter $parameter): self
    {
    }

	/**
	 * @return string[]
	 */
	public function getCustomJs(): array
    {
    }

	/**
	 * @param string $custom
	 * @return self
	 */
	public function addCustomJs(string $custom): self
    {
    }

	/**
	 * Serialize into JSON for client-side JS
	 */
	public function jsonSerializeDefinition(): array
    {
    }

	/**
	 * Check if parameters are satisfied in a StorageConfig
	 */
	public function validateStorageDefinition(StorageConfig $storage): bool
    {
    }
}
