# Commands 
[[toc]]

All Laraset Command listed :
| Command | Description |
|---                                        |---|
| `laraset:install`                         | Install laraset |
| [`#laraset:unit`](#make-unit)             | Create unit |
| [`#laraset:unit -d`](#delete-unit)        | Delete unit |
| [`#laraset:controller`](#make-controller) | Create controller for choosen unit |
| [`#laraset:model`](#make-model)           | Create model for choosen unit |
| `laraset:migration`                       | Create migration for choosen unit |
| `laraset:migrate`                         | Have the same behaviour as `php artisan migrate` but with units migrations |
| `laraset:units`                           | List all created and existant units |


## Make unit
```bash
php artisan laraset:unit [name]
```
<div class="console-containter">
    Example :
<pre class="console-code">
<m>$ </m><code>php artisan <span class="code">laraset:unit</span> Product</code>
<m>$ </m><code><span class="success">[directories] : finished</span></code>
<m>$ </m><code><span class="info">[Product] unit created successfully</span></code>
<m>$ </m><code>_</code>
</pre>
</div>

## Delete unit 
This command allow you to delete `Laraset` unit with double check
- select unit
- `yes` to confirm delete action
```
php artisan laraset:delete
```

<div class="console-containter">
    Example :
<pre class="console-code">
<m>$ </m><code>php artisan <span class="code">laraset:unit -d</span></code>
<m>$ </m><code class="question"><span class="success">Which Unit ?</span></code>
<m>  </m><code><span>[0] Product</span></code>
<m>> </m><code>Product</code>
<m>$ </m><code class="question"><span class="success">Confirm delete action for [Product] unit (yes/no) :</span></code>
<m>> </m><code>yes</code>
<m>$ </m><code>_</code>
</pre>
</div>

:::danger 
This Action is irreversable, you can't get back deleted units
:::

## Make Controller
```bash
php artisan laraset:controller [name]
```

<div class="console-containter">
    Example :
<pre class="console-code">
<m>$ </m><code>php artisan <span class="code">laraset:controller</span> Product</code>
<m>$ </m><code class="question"><span class="success">For Which Unit ?</span></code>
<m>  </m><code><span>[0] Product</span></code>
<m>> </m><code>Product <span class="comment">#or unit index in this case is : 0</span></code>
<m>$ </m><code><span class="info">[ProductController] created successfully</span></code>
<m>$ </m><code>_</code>
</pre>
</div>

Controller :
```php
namespace App\Laraset\units\Product\Controllers;

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
php artisan laraset:model [name]
```

<div class="console-containter">
    Example :
<pre class="console-code">
<m>$ </m><code>php artisan <span class="code">laraset:model</span> Product</code>
<m>$ </m><code class="question"><span class="success">For Which Unit ?</span></code>
<m>  </m><code><span>[0] Product</span></code>
<m>> </m><code>Product <span class="comment">#or unit index in this case is : 0</span></code>
<m>$ </m><code><span class="info">[Product] Model created successfully</span></code>
<m>$ </m><code>_</code>
</pre>
</div>
Model :

```php
namespace App\Laraset\units\Product\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
}
```
:::tip Model File Location
each unit Has his own Model files within `Laraset/units/Product/Database/Models` directory
:::
## Make Migration
```bash
php artisan laraset:migration [name]
```

<div class="console-containter">
    Example :
<pre class="console-code">
<m>$ </m><code>php artisan <span class="code">laraset:migration</span> products</code>
<m>$ </m><code class="question"><span class="success">For Which Unit ?</span></code>
<m>  </m><code><span>[0] Product</span></code>
<m>> </m><code>Product <span class="comment">#or unit index in this case is : 0</span></code>
<m>$ </m><code><span class="info">[CreateProductsTable] migration created successfully</span></code>
<m>$ </m><code>_</code>
</pre>
</div>

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
each unit Has his own Migration files within `Laraset/units/Product/Database/Migrations` directory
:::
