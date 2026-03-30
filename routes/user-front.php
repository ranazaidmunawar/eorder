<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'Front\FrontendController@userDetailView')->name('front.user.detail.view');

