<?php

namespace Khofaai\Laraset;

use Illuminate\Support\ServiceProvider;
use Khofaai\Laraset\core\Commands as LarasetCommandsCore;
use Khofaai\Laraset\core\Facades\Laraset;

class LarasetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services
     *
     * @return void
     */
    public function boot()
    {
        $this->loadCommands();
        $this->app->bind('laraset', function() {
            return new Laraset;
        });
    }

    /**
     * bind all commands to Laravel Console
     * 
     * @return void
     */
    private function loadCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                LarasetCommandsCore\LarasetDelete::class,
                LarasetCommandsCore\LarasetInstall::class,
                LarasetCommandsCore\LarasetMakeController::class,
                LarasetCommandsCore\LarasetMakeMigration::class,
                LarasetCommandsCore\LarasetMakeModel::class,
                LarasetCommandsCore\LarasetMakeModule::class,
                LarasetCommandsCore\LarasetModules::class,
                LarasetCommandsCore\LarasetMigrate::class
            ]);
        }
    }
}
