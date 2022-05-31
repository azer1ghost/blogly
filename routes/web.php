<?php

use Illuminate\Support\Facades\{Auth, Route};
use App\Http\Controllers\{PanelController, PostController, WebsiteController};

Route::redirect('/', 'articles')->name('index');

Route::controller(WebsiteController::class)
    ->group(function (){
        Route::get('articles', 'articles')->name('articles');
        Route::post('articles', 'getArticles');
        Route::get('article/{article:slug}', 'article')->name('article');
    });

Auth::routes();

Route::get('panel', PanelController::class)->name('panel');
Route::resource('posts', PostController::class);
