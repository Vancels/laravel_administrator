<?php
namespace Vancels\Administrator;

use Illuminate\Support\ServiceProvider;
use Vancels\Administrator\Facade\ToolsFacade;
use Vancels\Administrator\Service\ToolServiceInterface;

class AdministratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__ . '/../../viewComposers.php';
        include __DIR__ . '/../../administrator_routes.php';

        $this->loadViewsFrom(__DIR__ . '/../../views', 'administrator');
        $this->app['events']->fire('administrator.ready');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('tools', function ($app) {
            $cls = new ToolServiceInterface($app);

            return $cls;
        });

        $this->app->alias('Tools', ToolsFacade::class);
    }

}
