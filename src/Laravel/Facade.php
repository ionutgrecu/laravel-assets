<?php namespace Ionutgrecu\Assets\Laravel;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'ionutgrecu.assets.group.default';
	}

	/**
	 * Get the instance of the assets manager for a given group.
	 *
	 * @param  string $group
	 *
	 * @return \Ionutgrecu\Assets\Manager
	 *
	 * @throws \RuntimeException
	 */
	public static function group($group = 'default')
	{
		$binding = "ionutgrecu.assets.group.$group";

		if( ! static::$app->bound($binding))
			throw new \RuntimeException("Ionutgrecu\Assets: Assets group '$group' not found in the config file");

		return static::$app[$binding];
	}
}
