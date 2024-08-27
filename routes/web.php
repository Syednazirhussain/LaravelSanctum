<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::view('/email-verification', 'auth.verified-email')->name('email.verified');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');


Route::post('/auth/logout', function () {
    Auth::logout();
    return redirect()->intended();
})->name('logout');

Route::get('/auth/github/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('github_login');

Route::get('/github/callback', function (Request $request) {
    
    info(config('services.github.redirect'));
    info($request->all());

    $user = Socialite::driver('github')->user();

    $user = User::updateOrCreate([
        'github_id' => $user->getId(),
    ], [
        'name' => $user->getName(),
        'email' => $user->getEmail(),
        'github_token' => $user->token,
        'github_refresh_token' => $user->refreshToken,
        'password' => Hash::make('password')
    ]);
 
    Auth::login($user);

    return redirect()->intended();
});

Route::get('/auth/facebook/redirect', function () {
    return Socialite::driver('facebook')->redirect();
})->name('facebook_login');
Route::get('/facebook/callback', function (Request $request) {
    dd($request->all());
});

Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('google_login');
Route::get('/google/callback', function (Request $request) {
    dd($request->all());
});

Route::get('/auth/linkedin/redirect', function () {
    return Socialite::driver('linkedin')->redirect();
})->name('linkedin_login');
Route::get('/linkedin/callback', function (Request $request) {
    dd($request->all());
});
