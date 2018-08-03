<?php
/**
 * Author : Anas EL ALAMI [anaselalamikh@gmail.com]
 * github : khofaai
 */
namespace Khofaai\Laraset;

use Illuminate\Support\ServiceProvider;
use Khofaai\Laraset\core\Commands as LarasetCommandsCore;

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
