<?php

use App\Http\Controllers\TVMazeProxyApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function (Request $request) {
    $q = $request->get('q');

    if (!is_null($q)) {
        return (new TVMazeProxyApi())->show($q);
    } else {
        echo '?q=something - Required!';
    }
});
