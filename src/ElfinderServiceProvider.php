<?php

namespace Recca0120\Elfinder;

use Illuminate\Support\Arr;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ElfinderServiceProvider extends ServiceProvider
{
    /**
     * namespace.
     *
     * @var string
     */
    protected $namespace = 'Recca0120\Elfinder\Http\Controllers';

    /**
     * handle routes.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router)
    {
        $config = $this->app['config']['elfinder'];
        $this->handleRoutes($router, $config);
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'elfinder');

        if ($this->app->runningInConsole() === true) {
            $this->handlePublishes();
        }
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/elfinder.php', 'elfinder');

        $this->app->singleton(Elfinder::class, function ($app) {
            $session = new Session($app['session']);
            $config = $app['config']['elfinder'];

            return new Elfinder($session, $app['request'], $app['files'], $app['url'], $config);
        });
    }

    /**
     * register routes.
     *
     * @param \Illuminate\Routing\Router $router
     * @param array $config
     */
    protected function handleRoutes(Router $router, $config)
    {
        if ($this->app->routesAreCached() === false) {
            $router->group(array_merge([
                'middleware' => ['web', 'auth'],
                'prefix' => 'elfinder',
                'as' => 'elfinder.',
                'namespace' => $this->namespace,
            ], Arr::get($config, 'elfinder.route', [])), function () {
                require __DIR__.'/Http/routes.php';
            });
        }
    }

    /**
     * handle publishes.
     *
     * @return void
     */
    protected function handlePublishes()
    {
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/elfinder'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../resources/elfinder' => public_path('vendor/elfinder'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../config/elfinder.php' => config_path('elfinder.php'),
        ], 'config');
    }
}
