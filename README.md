# Bootcamp Laravel - Chirps

Refer to <https://bootcamp.laravel.com/blade/installation>.

## Day 1

Setup API

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

Return chirp details in `Api/ChirpController` in `show`:

```php
return new ChirpResource(Chirp::findOrFail($id));
```

## Day 2

Setup auth API endpoints - login, register & logout

Update your the OpenAPI Specification for Chirps API as in [here](public/oas-chirps.yaml).

Create new controller for handling Auth related:

```bash
php artisan make:controller Api/AuthController
```

Then update the controller as in [here](app/Http/Controllers/Api/AuthController.php).

Update the `routes/api.php`:

```php
<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChirpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/chirps', [ChirpController::class, 'index']);
Route::get('/chirps/{chirp}', [ChirpController::class, 'show']);
```

In `app/Models/User.php`, add `HasApiTokens` trait:

```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
```

Next, open up your Insomnia, create new collection. Import collection from [here](public/oas-chirps.yaml).

Then open up the Enviroment settings, update base environment as following:

```json
 {
 "scheme": "http",
 "base_path": "/api",
 "host": "127.0.0.1",
 "bearerToken": "bearerToken",
 "base_url": "{{ _.scheme }}://{{ _.host }}{{ _.base_path }}"
}
```

Now you can test your API endpoints for register, login and logout.

## React App

```bash
php artisan config:publish cors
```

Set the in `config/cors.php`:

```php
'supports_credentials' => true,
```

## Unit Test (Pest)

Install Pest:

```bash
composer remove phpunit/phpunit
composer require pestphp/pest --dev --with-all-dependencies
```

Setup Pest:

on Linux / Mac:

```bash
./vendor/bin/pest --init
```

on Windows, run:

```bash
vendor\bin\pest.bat --init
```

Create API unit test:

```bash
php artisan make:test ApiTest --pest
```

Update your unit test as in [here](tests/Feature/ApiTest.php).

To run the unit test, specifically to `tests/Feature/ApiTest.php`:

```bash
vendor/bin/pest tests/Feature/ApiTest.php
```

or on Windows:

```bash
vendor\bin\pest.bat tests/Feature/ApiTest.php
```

## Day 8

### Artisan Command

Create artisan command:

```bash
php artisan make:command ReloadAllCachesCommand
```

Then update the codes as in [here](app/Console/Commands/ReloadAllCachesCommand.php).

To use the command:

```bash
php artisan reload:caches
```

### Mail

Create mail class:

```bash
php artisan make:mail WelcomeMail
```

Update class as in [here](app/Mail/WelcomeMail.php).

Create view for welcome mail:

```bash
php artisan make:view mail.welcome
```

Update the mail view as in [here](resources/views/mail/welcome.blade.php).

Use `routes/console.php`, copy as in [here](routes/console.php).

Test the email:

```bash
php artisan test:mail
```

Open your browser at [http://127.0.0.1:8025](http://127.0.0.1:8025) to see new welcome email.

**Create Markdown Mail**

```bash
php artisan make:mail ThankYou --markdown
```

Update the view as in [here](resources/views/mail/thank-you.blade.php).

Use `routes/console.php`, copy as in [here](routes/console.php).


### Notification

Create `notifications` table.

```bash
php artisan make:notifications-table
php artisan migrate
```

Create notification class:

```bash
php artisan make:notification WelcomeNotification --markdown=notifications.welcome
```

Then update our `app/Notifications/WelcomeNotification.php` as in [here](app/Notifications/WelcomeNotification.php).

Then update the view for the notifications as in [here](resources/views/notifications/welcome.blade.php).

Send notification, by update `routes/console.php` as in [here](routes/console.php).

```bash
php artisan test:notify
```
