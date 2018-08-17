# Commands

## Delete Module
	laraset:delete [name]
>**name** : module name to be deleted
## Install
	laraset:install
>A <strong>Laraset/</strong> folder will be created inside <strong>app/</strong> folder all modules, and configuration will be <strong>app/Laraset/</strong> folder
## Make Controller for a specific Module
	laraset:make:controller [name]
**name** : controller name to be created <br>
>Then you choose target module for this [controller](https://laravel.com/docs/5.6/controllers)
## Make Migration for a specific Module
	laraset:make:migration [name]
**``--option``**
>Then you choose target module for this [migration](https://laravel.com/docs/5.6/migrations)
## Make Model for a specific Module
	laraset:make:model [name]
**``--option``**
>Then you choose target module for this [model](https://laravel.com/docs/5.6/eloquent)
## Make Module
	laraset:make:module [name]
>Creating Module inside <strong>app/Laraset/modules/``name``</strong>
## Modules
	laraset:modules
**``--option``**
## Migrate
	laraset:migrate [--no-sync]
**``--no-sync``** : if you ever create a new migration file but you don't want it to be executed with others