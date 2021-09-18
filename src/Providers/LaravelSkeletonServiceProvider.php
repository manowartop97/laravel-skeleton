<?php

namespace Manowartop\LaravelSkeleton\Providers;

use Illuminate\Support\ServiceProvider;
use Manowartop\LaravelSkeleton\CodeGenerator\Services\CodeGeneratorService;
use Manowartop\LaravelSkeleton\CodeGenerator\Services\Contracts\CodeGeneratorServiceInterface;
use Manowartop\LaravelSkeleton\CodeGenerator\Services\Contracts\DbManagerServiceInterface;
use Manowartop\LaravelSkeleton\CodeGenerator\Services\DbManagerService;
use Manowartop\LaravelSkeleton\Console\Commands\CrudGeneratorCommand;
use Manowartop\LaravelSkeleton\Console\Commands\ModelGeneratorCommand;
use Manowartop\LaravelSkeleton\Console\Commands\RepositoryAndServiceCodeGeneratorCommand;
use Manowartop\LaravelSkeleton\Console\Commands\RequestGeneratorCommand;
use Manowartop\LaravelSkeleton\Console\Commands\ResourceControllerGeneratorCommand;
use Manowartop\LaravelSkeleton\Console\Commands\ResourceGeneratorCommand;

/**
 * LaravelSkeletonServiceProvider
 */
class LaravelSkeletonServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {

    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/code_generator.php' => config_path('code_generator.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/../config/code_generator.php',
            'code_generator'
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                RepositoryAndServiceCodeGeneratorCommand::class,
                ResourceControllerGeneratorCommand::class,
                RequestGeneratorCommand::class,
                ModelGeneratorCommand::class,
                ResourceGeneratorCommand::class,
                CrudGeneratorCommand::class
            ]);
        }

        $this->app->singleton(CodeGeneratorServiceInterface::class, CodeGeneratorService::class);
        $this->app->singleton(DbManagerServiceInterface::class, DbManagerService::class);
    }
}
