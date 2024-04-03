<?php

use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
