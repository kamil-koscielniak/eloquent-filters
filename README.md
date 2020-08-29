# Laravel Eloquent filters

Laravel package for simply adding filters to Eloquent models.
  
## Instalation

```bash
composer require kamil-koscielniak/eloquent-filters
```

## Usage

#### Step 1 - Define filters in Eloquent model
```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use KamilKoscielniak\EloquentFilters\Filters\PartialFilter;
use KamilKoscielniak\EloquentFilters\Filters\RangeFilter;
use KamilKoscielniak\EloquentFilters\Traits\Filterable;

class Order extends Model
{
    use Filterable;
    
    public static array $filters = [
        'code' => PartialFilter::class,
        'price' => RangeFilter::class,
    ];
}
```

Note that the names of filters (`code` and `price` in above example) must be same as the column names in database table.

#### Step 2 - Filtering data

For example you can filter your data like this

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::filter($request)->get();

        return response()->json(compact('orders'));
    }
}
```

### Step 3 - Use filters in query string

Example url below will return orders with **price** between **21.99** and **99.99**
````
http://localhost/orders?price=21.99/99.99
````

## Available filter types

#### PartialFilter

For partial searching use `PartialFilter`

#### ExactFilter

For a thorough searching use `ExactFilter`

#### RangeFilter

For a range searching use `RangeFilter`
<br/>Use range separator `/` to separate min and max values

## Configuration

Run `php artisan vendor:publish --tag=config`
Config file you will find in `app/filters.php`

Available options

| Option                         | Default value | Description                                                                                       |
|--------------------------------|---------------|---------------------------------------------------------------------------------------------------|
| FILTERS_EXCLUSION_SUFFIX       |     &#124;e   | For exclusion value. Example usage<br> ?name=bike&#124;e                                          |
| FILTERS_RANGE_SEPARATOR        |      `/`      | For range searching. Use in query string. <br>Example usage<br>`?price=21.99/99.99`               |
| FILTERS_RELATIONSHIP_SEPARATOR |      `__`     | When you want to search in related object<br>use relationship separator<br>`?customer__name=mike` |

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
