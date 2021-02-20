<?php

if (interface_exists(\OCA\Files_External\Lib\Config\IBackendProvider::class)) {
	(new \OCA\Files_INotify\AppInfo\Application())->register();
}
