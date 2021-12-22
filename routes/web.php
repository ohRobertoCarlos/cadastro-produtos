<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/',function(){
    return redirect()->route('products.index');
});

Route::middleware('auth')->group(function(){
    Route::resources([
        'products' => ProductController::class,
        'tags' => TagController::class,
    ]);
});

Auth::routes();
