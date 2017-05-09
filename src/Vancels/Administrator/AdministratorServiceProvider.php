<?php
namespace Vancels\Administrator;

use Illuminate\Support\ServiceProvider;
use Vancels\Administrator\Console\CreateModelCommand;
use Vancels\Administrator\Console\ToolsCommand;
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
        // 非正式环境下
        if (env('APP_DEBUG')) {
            if (class_exists(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class)) {
                $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            }
        }


        $this->app->singleton('tools', function ($app) {
            $cls = new ToolServiceInterface($app);

            return $cls;
        });

        $this->app->alias('vTools', ToolsFacade::class);


        // 绑定命令行
        $this->app->singleton(
            'command.vancels.create_model',
            function ($app) {
                return new CreateModelCommand($app['files'], $app['view']);
            }
        );
        $this->app->singleton(
            'command.vancels.tools',
            function ($app) {
                return new ToolsCommand($app['files'], $app['view']);
            }
        );

        $this->commands('command.vancels.create_model','command.vancels.tools');
    }

}
