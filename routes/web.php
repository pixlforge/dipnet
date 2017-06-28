<?php

/**
 * Auth routes
 */
Auth::routes();
Route::get('/logout', 'SessionsController@destroy');

/**
 * Basic routes
 */
Route::get('/home', 'HomeController@index');
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
Route::post('/users', 'UsersController@store');
Route::get('/users/{user}/edit', 'UsersController@edit');
Route::put('/users/{user}', 'UsersController@update');
Route::delete('/users/{user}', 'UsersController@destroy');
Route::put('/users/{user}/restore', 'UsersController@restore');

/**
 * Business routes
 */
Route::get('/businesses', 'BusinessesController@index')->name('businesses');
Route::get('/businesses/create', 'BusinessesController@create');
Route::post('/businesses', 'BusinessesController@store');
Route::get('/businesses/{business}/edit', 'BusinessesController@edit');
Route::put('/businesses/{business}', 'BusinessesController@update');
Route::delete('/businesses/{business}', 'BusinessesController@destroy');
Route::put('/businesses/{business}/restore', 'BusinessesController@restore');

/**
 * Company routes
 */
Route::get('/companies', 'CompaniesController@index')->name('companies');
Route::get('/companies/create', 'CompaniesController@create');
Route::post('/companies', 'CompaniesController@store');
Route::get('/companies/{company}/edit', 'CompaniesController@edit');
Route::put('/companies/{company}', 'CompaniesController@update');
Route::delete('/companies/{company}', 'CompaniesController@destroy');
Route::put('/companies/{company}/restore', 'CompaniesController@restore');

/**
 * Contact routes
 */
Route::get('/contacts', 'ContactsController@index')->name('contacts');
Route::get('/contacts/create', 'ContactsController@create');
Route::post('/contacts', 'ContactsController@store');
Route::get('/contacts/{contact}/edit', 'ContactsController@edit');
Route::put('/contacts/{contact}', 'ContactsController@update');
Route::delete('/contacts/{contact}', 'ContactsController@destroy');
Route::put('/contacts/{contact}/restore', 'ContactsController@restore');

/**
 * Order routes
 */
Route::get('/orders', 'OrdersController@index')->name('orders');
Route::get('/orders/create', 'OrdersController@create');
Route::post('/orders', 'OrdersController@store');
Route::get('/orders/{order}/edit', 'OrdersController@edit');
Route::put('/orders/{order}', 'OrdersController@update');
Route::delete('/orders/{order}', 'OrdersController@destroy');
Route::put('/orders/{order}/restore', 'OrdersController@restore');

/**
 * Format routes
 */
Route::get('/formats', 'FormatsController@index')->name('formats');
Route::get('/formats/create', 'FormatsController@create');
Route::post('/formats', 'FormatsController@store');
Route::get('/formats/{format}/edit', 'FormatsController@edit');
Route::put('/formats/{format}', 'FormatsController@update');
Route::delete('/formats/{format}', 'FormatsController@destroy');
Route::put('/formats/{format}/restore', 'FormatsController@restore');

/**
 * Category routes
 */
Route::get('/categories', 'CategoriesController@index')->name('categories');
Route::get('/categories/create', 'CategoriesController@create');
Route::post('/categories', 'CategoriesController@store');
Route::get('/categories/{category}/edit', 'CategoriesController@edit');
Route::put('/categories/{category}', 'CategoriesController@update');
Route::delete('/categories/{category}', 'CategoriesController@destroy');

/**
 * Article routes
 */
Route::get('/articles', 'ArticlesController@index')->name('articles');
Route::get('/articles/create', 'ArticlesController@create');
Route::post('/articles', 'ArticlesController@store');
Route::get('/articles/{article}/edit', 'ArticlesController@edit');
Route::put('/articles/{article}', 'ArticlesController@update');
Route::delete('/articles/{article}', 'ArticlesController@destroy');
Route::put('/articles/{article}/restore', 'ArticlesController@restore');

/**
 * Document routes
 */
Route::get('/documents', 'DocumentsController@index')->name('documents');
Route::get('/documents/create', 'DocumentsController@create');
Route::post('/documents', 'DocumentsController@store');
Route::get('/documents/{document}/edit', 'DocumentsController@edit');
Route::put('/documents/{document}', 'DocumentsController@update');

/**
 * Delivery routes
 */
Route::get('/deliveries', 'DeliveriesController@index')->name('deliveries');
Route::get('/deliveries/create', 'DeliveriesController@create');
Route::post('/deliveries', 'DeliveriesController@store');
Route::get('/deliveries/{delivery}/edit', 'DeliveriesController@edit');
Route::put('/deliveries/{delivery}', 'DeliveriesController@update');
Route::delete('/deliveries/{delivery}', 'DeliveriesController@destroy');
Route::put('/deliveries/{delivery}/restore', 'DeliveriesController@restore');

/**
 * Profiles
 */
Route::get('/profile', 'ProfilesController@profile')->name('profile');
Route::get('/profile/{user}/edit', 'ProfilesController@edit');
Route::put('/profile/{user}', 'ProfilesController@update');
Route::get('/profile/details', 'ProfilesController@details');