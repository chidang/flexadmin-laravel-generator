<?php

namespace Techamz\Generator;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Techamz\Generator\Commands\API\APIControllerGeneratorCommand;
use Techamz\Generator\Commands\API\APIGeneratorCommand;
use Techamz\Generator\Commands\API\APIRequestsGeneratorCommand;
use Techamz\Generator\Commands\API\TestsGeneratorCommand;
use Techamz\Generator\Commands\APIScaffoldGeneratorCommand;
use Techamz\Generator\Commands\Common\MigrationGeneratorCommand;
use Techamz\Generator\Commands\Common\ModelGeneratorCommand;
use Techamz\Generator\Commands\Common\RepositoryGeneratorCommand;
use Techamz\Generator\Commands\Publish\GeneratorPublishCommand;
use Techamz\Generator\Commands\Publish\PublishTablesCommand;
use Techamz\Generator\Commands\Publish\PublishUserCommand;
use Techamz\Generator\Commands\RollbackGeneratorCommand;
use Techamz\Generator\Commands\Scaffold\ControllerGeneratorCommand;
use Techamz\Generator\Commands\Scaffold\RequestsGeneratorCommand;
use Techamz\Generator\Commands\Scaffold\ScaffoldGeneratorCommand;
use Techamz\Generator\Commands\Scaffold\ViewsGeneratorCommand;
use Techamz\Generator\Common\FileSystem;
use Techamz\Generator\Common\GeneratorConfig;
use Techamz\Generator\Generators\API\APIControllerGenerator;
use Techamz\Generator\Generators\API\APIRequestGenerator;
use Techamz\Generator\Generators\API\APIRoutesGenerator;
use Techamz\Generator\Generators\API\APITestGenerator;
use Techamz\Generator\Generators\FactoryGenerator;
use Techamz\Generator\Generators\MigrationGenerator;
use Techamz\Generator\Generators\ModelGenerator;
use Techamz\Generator\Generators\RepositoryGenerator;
use Techamz\Generator\Generators\RepositoryTestGenerator;
use Techamz\Generator\Generators\Scaffold\ControllerGenerator;
use Techamz\Generator\Generators\Scaffold\MenuGenerator;
use Techamz\Generator\Generators\Scaffold\RequestGenerator;
use Techamz\Generator\Generators\Scaffold\RoutesGenerator;
use Techamz\Generator\Generators\Scaffold\ViewGenerator;
use Techamz\Generator\Generators\SeederGenerator;

class TechamzGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        if ($this->app->runningInConsole()) {
            $configPath = __DIR__.'/../config/flex_laravel_generator.php';
            $this->publishes([
                $configPath => config_path('flex_laravel_generator.php'),
            ], 'flex-laravel-generator-config');

            $this->publishes([
                __DIR__.'/../views' => resource_path('views/vendor/flex-laravel-generator'),
            ], 'flex-laravel-generator-templates');
        }

        $this->registerCommands();
        $this->loadViewsFrom(__DIR__.'/../views', 'flex-laravel-generator');

        View::composer('*', function ($view) {
            $view->with(['config' => app(GeneratorConfig::class)]);
        });

        Blade::directive('tab', function () {
            return '<?php echo techamz_tab() ?>';
        });

        Blade::directive('tabs', function ($count) {
            return "<?php echo techamz_tabs($count) ?>";
        });

        Blade::directive('nl', function () {
            return '<?php echo techamz_nl() ?>';
        });

        Blade::directive('nls', function ($count) {
            return "<?php echo techamz_nls($count) ?>";
        });
    }

    private function registerCommands()
    {
        // if (!$this->app->runningInConsole()) {
        //     return;
        // }

        $this->commands([
            APIScaffoldGeneratorCommand::class,

            APIGeneratorCommand::class,
            APIControllerGeneratorCommand::class,
            APIRequestsGeneratorCommand::class,
            TestsGeneratorCommand::class,

            MigrationGeneratorCommand::class,
            ModelGeneratorCommand::class,
            RepositoryGeneratorCommand::class,

            GeneratorPublishCommand::class,
            PublishTablesCommand::class,
            PublishUserCommand::class,

            ControllerGeneratorCommand::class,
            RequestsGeneratorCommand::class,
            ScaffoldGeneratorCommand::class,
            ViewsGeneratorCommand::class,

            RollbackGeneratorCommand::class,
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/flex_laravel_generator.php', 'flex_laravel_generator');

        $this->app->singleton(GeneratorConfig::class, function () {
            return new GeneratorConfig();
        });

        $this->app->singleton(FileSystem::class, function () {
            return new FileSystem();
        });

        $this->app->singleton(MigrationGenerator::class);
        $this->app->singleton(ModelGenerator::class);
        $this->app->singleton(RepositoryGenerator::class);

        $this->app->singleton(APIRequestGenerator::class);
        $this->app->singleton(APIControllerGenerator::class);
        $this->app->singleton(APIRoutesGenerator::class);

        $this->app->singleton(RequestGenerator::class);
        $this->app->singleton(ControllerGenerator::class);
        $this->app->singleton(ViewGenerator::class);
        $this->app->singleton(RoutesGenerator::class);
        $this->app->singleton(MenuGenerator::class);

        $this->app->singleton(RepositoryTestGenerator::class);
        $this->app->singleton(APITestGenerator::class);

        $this->app->singleton(FactoryGenerator::class);
        $this->app->singleton(SeederGenerator::class);
    }
}
