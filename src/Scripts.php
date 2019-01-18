<?php

namespace App;

use Composer\Script\Event;
use Composer\Composer;

class Scripts
{
	/**
	 * @param $event
	 */
	public static function postCreateProject(Event $event): void
	{
		$vendorDirectory = $event->getComposer()->getConfig()->get('vendor-dir');

		var_dump($vendorDirectory);
	}
}