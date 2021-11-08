<?php

namespace Tomeet\FriendlyLink;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class FriendlyLinkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupRoutes($this->app->router);
        $this->publishes([
            \dirname(__DIR__) . '/migrations/' => database_path('migrations')
        ], 'friendly-link');
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $this->loadRoutesFrom(__DIR__ . '/Http/Routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/Http/Routes/app.php');
    }
}
