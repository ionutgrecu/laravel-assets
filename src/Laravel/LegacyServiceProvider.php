<?php namespace Ionutgrecu\Assets\Laravel;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Ionutgrecu\Assets\Manager as Assets;

class LegacyServiceProvider extends LaravelServiceProvider
{
	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Register the package namespace
		//$this->package('stolz/assets'); // Only valid if config file is at src/config/config.php
		$this->app->config->package('stolz/assets', __DIR__, 'assets');

		// Read settings from config file
		$config = $this->app->config->get('assets::config', []);

		// Apply config settings
		$this->app['ionutgrecu.assets.group.default']->config($config);

		// Add 'Assets' facade alias
		AliasLoader::getInstance()->alias('Assets', Facade::class);

		// Add artisan command
		$this->commands('ionutgrecu.assets.command.flush');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Bind 'ionutgrecu.assets.group.default' shared component to the IoC container
		$this->app->singleton('ionutgrecu.assets.group.default', function ($app) {
			return new Assets();
		});

		// Bind 'ionutgrecu.assets.command.flush' component to the IoC container
		$this->app->bind('ionutgrecu.assets.command.flush', function ($app) {
			return new LegacyFlushPipelineCommand();
		});
	}
}
