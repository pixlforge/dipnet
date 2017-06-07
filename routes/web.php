<?php

/**
 * Auth routes
 */
Auth::routes();
Route::get('/logout', 'SessionsController@destroy');
Route::get('/home', 'HomeController@index');

/**
 * Basic routes
 */
Route::get('/', 'PagesController@index')->name('index');

/**
 * Admin routes
 */
Route::get('/admin/dashboard', 'AdminController@dashboard')->name('dashboard');

/**
 * User routes
 */
Route::get('/users', 'UsersController@index')->name('users');
Route::get('/users/create', 'UsersController@create');
Route::get('/users/{user}', 'UsersController@show');
Route::post('/users', 'UsersController@store');
Route::get('/users/{user}/edit', 'UsersController@edit');
Route::put('/users/{user}', 'UsersController@update');

/**
 * Business routes
 */
Route::get('/businesses', 'BusinessesController@index')->name('businesses');
Route::get('/businesses/create', 'BusinessesController@create');
Route::get('/businesses/{business}', 'BusinessesController@show');
Route::post('/businesses', 'BusinessesController@store');
Route::get('/businesses/{business}/edit', 'BusinessesController@edit');
Route::put('/businesses/{business}', 'BusinessesController@update');

/**
 * Company routes
 */
Route::get('/companies', 'CompaniesController@index')->name('companies');
Route::get('/companies/create', 'CompaniesController@create');
Route::get('/companies/{company}', 'CompaniesController@show');
Route::post('/companies', 'CompaniesController@store');
Route::get('/companies/{company}/edit', 'CompaniesController@edit');
Route::put('/companies/{company}', 'CompaniesController@update');

/**
 * Contact routes
 */
Route::get('/contacts', 'ContactsController@index')->name('contacts');
Route::get('/contacts/create', 'ContactsController@create');
Route::get('/contacts/{contact}', 'ContactsController@show');
Route::post('/contacts', 'ContactsController@store');
Route::get('/contacts/{contact}/edit', 'ContactsController@edit');
Route::put('/contacts/{contact}', 'ContactsController@update');

/**
 * Order routes
 */
Route::get('/orders', 'OrdersController@index')->name('orders');
Route::get('/orders/create', 'OrdersController@create');
Route::get('/orders/{order}', 'OrdersController@show');
Route::post('/orders', 'OrdersController@store');
Route::get('/orders/{order}/edit', 'OrdersController@edit');
Route::put('/orders/{order}', 'OrdersController@update');

/**
 * Format routes
 */
Route::get('/formats', 'FormatsController@index')->name('formats');
Route::get('/formats/create', 'FormatsController@create');
Route::get('/formats/{format}', 'FormatsController@show');
Route::post('/formats', 'FormatsController@store');
Route::get('/formats/{format}/edit', 'FormatsController@edit');
Route::put('/formats/{format}', 'FormatsController@update');

/**
 * Category routes
 */
Route::get('/categories', 'CategoriesController@index')->name('categories');
Route::get('/categories/create', 'CategoriesController@create');
Route::get('/categories/{category}', 'CategoriesController@show');
Route::post('/categories', 'CategoriesController@store');
Route::get('/categories/{category}/edit', 'CategoriesController@edit');
Route::put('/categories/{category}', 'CategoriesController@update');

/**
 * Article routes
 */
Route::get('/articles', 'ArticlesController@index')->name('articles');
Route::get('/articles/create', 'ArticlesController@create');
Route::get('/articles/{article}', 'ArticlesController@show');
Route::post('/articles', 'ArticlesController@store');
Route::get('/articles/{article}/edit', 'ArticlesController@edit');
Route::put('/articles/{article}', 'ArticlesController@update');

/**
 * Document routes
 */
Route::get('/documents', 'DocumentsController@index')->name('documents');
Route::get('/documents/create', 'DocumentsController@create');
Route::get('/documents/{document}', 'DocumentsController@show');
Route::post('/documents', 'DocumentsController@store');
Route::get('/documents/{document}/edit', 'DocumentsController@edit');
Route::put('/documents/{document}', 'DocumentsController@update');

/**
 * Delivery routes
 */
Route::get('/deliveries', 'DeliveriesController@index')->name('deliveries');
Route::get('/deliveries/create', 'DeliveriesController@create');
Route::get('/deliveries/{delivery}', 'DeliveriesController@show');
Route::post('/deliveries', 'DeliveriesController@store');
Route::get('/deliveries/{delivery}/edit', 'DeliveriesController@edit');
Route::put('/deliveries/{delivery}', 'DeliveriesController@update');