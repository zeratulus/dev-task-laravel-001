<?php

use App\Http\Controllers\TVMazeProxyApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//API according Laravel best practices MUST BE at https://example.com/api/...

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/v1/{q}', [TVMazeProxyApi::class, 'show']);

Route::get('/v2/', function (Request $request) {
    $q = $request->get('q');
    return (new TVMazeProxyApi())->show($q);
});
