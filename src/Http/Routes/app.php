<?php

use Illuminate\Support\Facades\Route;
use Tomeet\FriendlyLink\Http\Controllers\Admin\FriendlyLinkGroupController;
use Tomeet\FriendlyLink\Http\Controllers\Admin\FriendlyLinkController;

/**
 * 友情链接
 */
Route::prefix('app')->group(function () {
    Route::middleware('auth:api')->group(function () {

    });
});

