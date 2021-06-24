<?php

use App\Jobs\TestJob;
use App\Models\User;
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

Route::get('/storage', function(){
    Storage::disk('s3')->put('file.txt', 'Content from tenant: '. Tenant::current()->domain, ['visibility' => 'public']);
    $url = Storage::disk('s3')->url('file.txtclear');
    return response()->json("File created .... url: {$url}");
});
