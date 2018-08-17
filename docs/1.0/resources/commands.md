# Laraset Commands

All Laraset Command listed :
| Command | Description |
|---                                            |---|
| `laraset:install`                             | Install laraset |
| [`#laraset:delete`](#delete-module)            | Delete module |
| [`#laraset:make:module`](#make-module)         | Create module |
| [`#laraset:make:controller`](#make-controller) | Create controller for choosen module |
| [`#laraset:make:model`](#make-model)           | Create model for choosen module |
| `laraset:make:migration`                      | Create migration for choosen module |
| `laraset:migrate`                             | Have the same behaviour as `php artisan migrate` but with modules migrations |
| `laraset:modules`                             | List all created and existant modules |

 


#make-migration

## Make module
```bash
php artisan laraset:make:module [name]
```
![Laraset Make module](./img/laraset-make-module.png)

## Delete Module 
This command allow you to delete `Laraset` module with double check
- select module
- `yes` to confirm delete action
```
php artisan laraset:delete
```
![Laraset Delete](./img/laraset-delete.png)
:::danger 
This Action is irreversable, you can't get back deleted modules
:::

## Make Controller
```bash
php artisan laraset:make:controller [name]
```
![Laraset Make Controller](./img/laraset-make-controller.png)

```php
namespace App\Laraset\modules\Nova\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function index(Request $request)
    {
        //
    }
}
```

## Make Model
```bash
php artisan laraset:make:model [name]
```
![Laraset Make Model](./img/laraset-make-model.png)

```php
namespace App\Laraset\modules\Nova\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
}
```
:::tip Model File Location
each Module Has his own Model files within `Laraset/Nova/Database/Models` directory
:::
## Make Migration
```bash
php artisan laraset:make:migration [name]
```
![Laraset Make Migration](./img/laraset-make-migration.png)

```php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->rememberToken();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
```
:::tip Migration File Location
each Module Has his own Migration files within `Laraset/Nova/Database/Migrations` directory
:::
