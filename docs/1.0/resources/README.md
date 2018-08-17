# The Basics

[[toc]]

**Laraset** is a module manager using Laravel artisan CLI. Tt's targets all preset Laravel uses. it has the ability to Create Delete Modules that wrap all laravel features & preset used in one folder that can exported or event imported from project to another. for now we still in dev phase and supporting only VueJs2

## To use Laraset

By default, Laraset in not installed to use it you should run `laraset:install` command :

```bash
php artisan laraset:install
```
Then `Laraset` Folder will be generated inside `app` Folder : 

![Laraset Architecture](./img/laraset-architecture.png) <br>

:::tip Module Location

By default, all modules will be stored  within the  `app/Laraset/modules` directory.
:::
