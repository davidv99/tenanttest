<?php

use App\Jobs\TestJob;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Placetopay\Cerberus\Models\Tenant;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jobs', function (){
    dispatch(new TestJob(User::first()));

    return response()->json('job dispatched');
});

Route::get('/cache', function (){
    cache()->put('key_1', 'value_1');
    cache()->put('key_2', 'value_2');

    return response()->json('Cache generated');
});

Route::get('/storage-serverless', function(){
    Storage::disk('s3')->put('file.txt', 'Content storage in s3: ', ['visibility' => 'public']);
    $url = Storage::disk('s3')->url('file.txt');
    return response()->json("File created .... url: {$url}");
});


Route::get('/asset', function(){
    return asset('css/test.css');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/*Route::get('/locale', function(){
   $locales = collect(['es', 'es_CO', 'en_US', 'en_UK']);

   $locales->each(function ($locale) {
       \Carbon\Carbon::setLocale($locale);
        dump([
            'locale' => $locale,
            'now' => \Carbon\Carbon::now()->isoFormat('MMMM dddd Y'),
        ]);
    });
});*/

/*Route::get('/timezone', function (){

    Carbon::macro('userTz', static function ($userTimezone = 'auth()->user()') {
        $date = self::this()->copy()->tz('America/Bogota');

        return $date; // or ->isoFormat($customFormat), ->diffForHumans(), etc.
    });

    $locales = collect(['es', 'es_CO', 'en_US', 'en_UK']);

    $locales->each(function ($locale) {
        \Carbon\Carbon::setLocale($locale);
        $user = User::first();
        dump([
            'locale' => $locale,
            'timezone' => $user->timezone,
            'now' => Carbon::now()->userTz($user->timezone),
            'user_original' => $user->created_at->calendar(),
            'user_formated' => $user->created_at->userTz($user->timezone)->diffForHumans(),
        ]);
    });
});*/
