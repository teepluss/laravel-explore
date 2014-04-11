<?php namespace Teepluss\Explore;

use Illuminate\Support\ServiceProvider;

class ExploreServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('teepluss/explore');

		include __DIR__.'/../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerExplore();

		$this->registerFacade();
	}

	/**
	 * Register explore.
	 *
	 * @return void
	 */
	protected function registerExplore()
	{
		$this->app['explore'] = $this->app->share(function($app)
		{
			return new Explore();
		});
	}

	/**
	 * Register facade.
	 *
	 * @return void
	 */
	protected function registerFacade()
	{
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();

			$loader->alias('Explore', 'Teepluss\Explore\Facades\Explore');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('explore');
	}

}
