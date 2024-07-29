<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});

// routes/web.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    $query = http_build_query([
        'client_id' => env('OAUTH_CLIENT_ID'),
        'redirect_uri' => env('OAUTH_REDIRECT_URI'),
        'response_type' => 'code',
        'scope' => '',
    ]);

    // dd(env('OAUTH_SERVER_URL') . '/oauth/authorize?' . $query);

    return redirect(env('OAUTH_SERVER_URL') . '/oauth/authorize?' . $query);
});
//dylep@mailinator.com
Route::get('/oauth/callback', function (Request $request) {
    $response = Http::asForm()->post(env('OAUTH_SERVER_URL') . '/oauth/token', [
        'grant_type' => 'authorization_code',
        'client_id' => env('OAUTH_CLIENT_ID'),
        'client_secret' => env('OAUTH_CLIENT_SECRET'),
        'redirect_uri' => env('OAUTH_REDIRECT_URI'),
        'code' => $request->code,
    ]);

    try {
        $data = $response->json();
        $accessToken = data_get($data, 'access_token');

        $response = Http::withToken($accessToken)->get(env('OAUTH_SERVER_URL') . '/api/user');

        abort_if(! $response->ok(), 'Invalid Crendentials');

        $data = $response->json();

        if(! User::where('email', data_get($data, 'email'))->exists()) {
            $user = User::create([
                'name' => data_get($data, 'name'),
                'email' => data_get($data, 'email'),
                'password' => Hash::make(date('Ymd').rand(1,10000))
            ]);
        } else {
            $user = User::where('email', data_get($data, 'email'))->first();
        }

        Auth::login($user);

        return redirect('profile');

    } catch (\Throwable $th) {
        abort(401, $th->getMessage());
    }
});
