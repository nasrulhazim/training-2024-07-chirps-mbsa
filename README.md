# Bootcamp Laravel - Chirps

Refer to <https://bootcamp.laravel.com/blade/installation>.

## Setup API

```bash
php artisan install:api
```

Create Chirp API Controllers:

```bash
php artisan make:controller Api/ChirpController --api
```

Define API Route for Chirp in `routes/api.php`:

```php
<?php

use App\Http\Controllers\Api\ChirpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/chirps', [ChirpController::class, 'index']);
```

Create Chirp resource & collection:

```bash
php artisan make:resource ChirpResource
php artisan make:resource ChirpCollection
```

Disable `data` wraping in resource:

```php
<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
```

Return list of chirps in `Api/ChirpController` in `index`:

```php
return new ChirpCollection(Chirp::all());
```
