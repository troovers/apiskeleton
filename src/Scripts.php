<?php

namespace App;

use Composer\Composer;
use Composer\Script\Event;

class Scripts
{
	/**
	 * @param $event
	 * @throws \Exception
	 */
	public static function postCreateProject(Event $event): void
	{
		\Esites\ApiBundle\Scripts::postCreateProject($event);

		$rootDir = $event->getComposer()->getConfig()->get('vendor-dir') . '/..';

		self::copyEnvironmentVariables($rootDir);
	}


	/**
	 * @param string $rootDir
	 * @throws \Exception
	 */
	private static function copyEnvironmentVariables(string $rootDir): void
	{
		// Copy the .env.dist file to a .env file
		copy($rootDir . '/.env.template', $rootDir . '/.env');
		copy($rootDir . '/.env.local.template', $rootDir . '/.env.local');

		$env = file_get_contents($rootDir . '/.env');
		$env = str_replace([
			'{{APP_ENV}}',
			'{{APP_SECRET}}',
			'{{BASE_URL}}',
		], [
			'dev',
			bin2hex(random_bytes(16)),
			'project.test'
		], $env);

		file_put_contents($rootDir . '/.env', $env);
	}
}