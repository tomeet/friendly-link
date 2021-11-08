<?php

use Illuminate\Support\Facades\Route;
use Tomeet\FriendlyLink\Http\Controllers\Admin\FriendlyLinkGroupController;
use Tomeet\FriendlyLink\Http\Controllers\Admin\FriendlyLinkController;

/**
 * 友情链接
 */
Route::prefix('admin/api')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::prefix('friendly')->name('friendly.')->group(function () {
            // 分组信息
            Route::patch('/groups/{group}/order', [FriendlyLinkGroupController::class, 'setShowOrder'])->name('groups.order');
            Route::delete('/groups', [FriendlyLinkGroupController::class, 'massDestroy'])->name('groups.mass.delete');
            // 链接信息
            Route::patch('/links/{link}/order', [FriendlyLinkController::class, 'setShowOrder'])->name('links.order');
            Route::delete('/links', [FriendlyLinkController::class, 'massDestroy'])->name('links.mass.delete');
            Route::apiResources([
                'groups' => FriendlyLinkGroupController::class,
                'links' => FriendlyLinkController::class,
            ]);
        });
    });
});


