<?php

/**
 * Basic routes
 */
Route::get('/', 'PagesController@welcome');
Route::get('/index', 'PagesController@index')->name('home');

/**
 * User routes
 */
Route::resource('/users', 'UsersController');

/**
 * Business routes
 */
Route::resource('/businesses', 'BusinessesController');

/**
 * Company routes
 */
Route::resource('/companies', 'CompaniesController');

/**
 * Contact routes
 */
Route::resource('/contacts', 'ContactsController');

/**
 * Order routes
 */
Route::resource('/orders', 'OrdersController');

/**
 * Format routes
 */
Route::resource('/formats', 'FormatsController');

/**
 * Category routes
 */
Route::resource('/categories', 'CategoriesController');

/**
 * Article routes
 */
Route::resource('/articles', 'ArticlesController');

/**
 * Document routes
 */
Route::resource('/documents', 'DocumentsController');

/**
 * Delivery routes
 */
Route::resource('/deliveries', 'DeliveriesController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
