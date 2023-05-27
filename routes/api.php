<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// FRONT CONFIG
Route::get('config', [App\Http\Controllers\ConfigController::class, 'index']);

// FRONT BANNERS
Route::get('banners', [App\Http\Controllers\BannerController::class, 'index']);

// FRONT SCREENSAVERS
Route::get('screensavers', [App\Http\Controllers\ScreensaverController::class, 'index']);

// FRONT PAGES
Route::get('pages', [App\Http\Controllers\PageController::class, 'index']);
Route::get('page/{id}', [App\Http\Controllers\PageController::class, 'page']);

// FRONT SCHEMES
Route::get('schemes', [App\Http\Controllers\SchemeController::class, 'index']);

// FRONT ROUTES
Route::get('routes/{kiosk}', [App\Http\Controllers\RouteController::class, 'index']);
Route::get('route/{id}', [App\Http\Controllers\RouteController::class, 'route']);

// FRONT POINTS
Route::get('points', [App\Http\Controllers\PointController::class, 'index']);

// FRONT KIOSKS
Route::get('kiosks', [App\Http\Controllers\KioskController::class, 'index']);

// FRONT EVENTS
Route::get('events', [App\Http\Controllers\EventController::class, 'index']);

// ADMIN CONFIG
Route::get('admin/config', [App\Http\Controllers\Admin\ConfigController::class, 'index']);
Route::put('admin/config-update', [App\Http\Controllers\Admin\ConfigController::class, 'update']);

// ADMIN PAGES
Route::get('admin/pages', [App\Http\Controllers\Admin\PageController::class, 'index']);
Route::post('admin/pages', [App\Http\Controllers\Admin\PageController::class, 'store']);
Route::post('admin/pages-reorder', [App\Http\Controllers\Admin\PageController::class, 'reorderPages']);
Route::get('admin/page/{id}', [App\Http\Controllers\Admin\PageController::class, 'page']);
Route::put('admin/page/{id}/update', [App\Http\Controllers\Admin\PageController::class, 'update']);
Route::delete('admin/page/{id}/delete', [App\Http\Controllers\Admin\PageController::class, 'delete']);

// ADMIN BLOCKS
Route::post('admin/blocks', [App\Http\Controllers\Admin\BlockController::class, 'store']);
Route::put('admin/block/{id}/update', [App\Http\Controllers\Admin\BlockController::class, 'update']);

// ADMIN KIOSKS
Route::get('admin/kiosks', [App\Http\Controllers\Admin\KioskController::class, 'index']);
Route::post('admin/kiosks', [App\Http\Controllers\Admin\KioskController::class, 'store']);
Route::get('admin/kiosk/{id}', [App\Http\Controllers\Admin\KioskController::class, 'kiosk']);
Route::put('admin/kiosk/{id}/update', [App\Http\Controllers\Admin\KioskController::class, 'update']);
Route::delete('admin/kiosk/{id}/delete', [App\Http\Controllers\Admin\KioskController::class, 'delete']);

// ADMIN SCHEMES
Route::get('admin/schemes', [App\Http\Controllers\Admin\SchemeController::class, 'index']);
Route::post('admin/schemes', [App\Http\Controllers\Admin\SchemeController::class, 'store']);
Route::get('admin/scheme/{id}', [App\Http\Controllers\Admin\SchemeController::class, 'scheme']);
Route::put('admin/scheme/{id}/update', [App\Http\Controllers\Admin\SchemeController::class, 'update']);
Route::delete('admin/scheme/{id}/delete', [App\Http\Controllers\Admin\SchemeController::class, 'delete']);

// ADMIN ROUTES
Route::get('admin/routes/{kiosk}', [App\Http\Controllers\Admin\RouteController::class, 'index']);
Route::post('admin/routes', [App\Http\Controllers\Admin\RouteController::class, 'store']);
Route::get('admin/route/{id}', [App\Http\Controllers\Admin\RouteController::class, 'route']);
Route::put('admin/route/{id}/update', [App\Http\Controllers\Admin\RouteController::class, 'update']);
Route::delete('admin/route/{id}/delete', [App\Http\Controllers\Admin\RouteController::class, 'delete']);

// ADMIN BANNERS
Route::get('admin/banners', [App\Http\Controllers\Admin\BannerController::class, 'index']);
Route::post('admin/banners', [App\Http\Controllers\Admin\BannerController::class, 'store']);
Route::get('admin/banner/{id}', [App\Http\Controllers\Admin\BannerController::class, 'banner']);
Route::put('admin/banner/{id}/update', [App\Http\Controllers\Admin\BannerController::class, 'update']);
Route::delete('admin/banner/{id}/delete', [App\Http\Controllers\Admin\BannerController::class, 'delete']);

// ADMIN SCREENSAVERS
Route::get('admin/screensavers', [App\Http\Controllers\Admin\ScreensaverController::class, 'index']);
Route::post('admin/screensavers', [App\Http\Controllers\Admin\ScreensaverController::class, 'store']);
Route::get('admin/screensaver/{id}', [App\Http\Controllers\Admin\ScreensaverController::class, 'screensaver']);
Route::put('admin/screensaver/{id}/update', [App\Http\Controllers\Admin\ScreensaverController::class, 'update']);
Route::delete('admin/screensaver/{id}/delete', [App\Http\Controllers\Admin\ScreensaverController::class, 'delete']);

// ADMIN ICONS
Route::get('admin/icons', [App\Http\Controllers\Admin\IconController::class, 'index']);
Route::post('admin/icons', [App\Http\Controllers\Admin\IconController::class, 'store']);
Route::delete('admin/icon/{id}/delete', [App\Http\Controllers\Admin\IconController::class, 'delete']);

// ADMIN FILE UPLOAD
Route::post('admin/file/upload', [App\Http\Controllers\Admin\FileController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});