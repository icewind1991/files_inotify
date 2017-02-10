<?php
(new \OCA\Files_INotify\AppInfo\Application())->register();


// Mock the Nextcloud 12 notify classes and interfaces when running on Nextcloud 11
if (!class_exists('OCP\Files\Notify\INotifyHandler')) {
	require_once 'compat.php';
}
