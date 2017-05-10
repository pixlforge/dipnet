<?php

/**
 * Basic routes
 */
Route::get('/', 'PagesController@welcome');
Route::get('/index', 'PagesController@index')->name('home');

/**
 * User routes
 */
Route::get('/users', 'UsersController@index');
Route::get('/users/create', 'UsersController@create');
Route::post('/users', 'UsersController@store');
Route::get('/users/{user}', 'UsersController@show');
Route::get('/users/{user}/edit', 'UsersController@edit');
Route::patch('/users/{user}', 'UsersController@update');
Route::delete('/users/{user}', 'UsersController@destroy');

/**
 * Business routes
 */
Route::get('/businesses', 'BusinessesController@index');
Route::get('/businesses/create', 'BusinessesController@create');
Route::post('/businesses', 'BusinessesController@store');
Route::get('/businesses/{business}', 'BusinessesController@show');
Route::get('/businesses/{business}/edit', 'BusinessesController@edit');
Route::patch('/businesses/{business}', 'BusinessesController@update');
Route::delete('/businesses/{business}', 'BusinessesController@destroy');

/**
 * Company routes
 */
Route::get('/companies', 'CompaniesController@index');
Route::get('/companies/create', 'CompaniesController@create');
Route::post('/companies', 'CompaniesController@store');
Route::get('/companies/{company}', 'CompaniesController@show');
Route::get('/companies/{company}/edit', 'CompaniesController@edit');
Route::patch('/companies/{company}', 'CompaniesController@update');
Route::delete('/companies/{company}', 'CompaniesController@destroy');

/**
 * Contact routes
 */
Route::get('/contacts', 'ContactsController@index');
Route::get('/contacts/create', 'ContactsController@create');
Route::post('/contacts', 'ContactsController@store');
Route::get('/contacts/{contact}', 'ContactsController@show');
Route::get('/contacts/{contact}/edit', 'ContactsController@edit');
Route::patch('/contacts/{contact}', 'ContactsController@update');
Route::delete('/contacts/{contact}', 'ContactsController@destroy');

/**
 * Order routes
 */
Route::get('/orders', 'OrdersController@index');
Route::get('/orders/create', 'OrdersController@create');
Route::post('/orders', 'OrdersController@store');
Route::get('/orders/{order}', 'OrdersController@show');
Route::get('/orders/{order}/edit', 'OrdersController@edit');
Route::patch('/orders/{order}', 'OrdersController@update');
Route::delete('/orders/{order}', 'OrdersController@destroy');

/**
 * Format routes
 */
Route::get('/formats', 'FormatsController@index');
Route::get('/formats/create', 'FormatsController@create');
Route::post('/formats', 'FormatsController@store');
Route::get('/formats/{format}', 'FormatsController@show');
Route::get('/formats/{format}/edit', 'FormatsController@edit');
Route::patch('/formats/{format}', 'FormatsController@update');
Route::delete('/formats/{format}', 'FormatsController@destroy');

/**
 * Category routes
 */
Route::get('/categories', 'CategoriesController@index');
Route::get('/categories/create', 'CategoriesController@create');
Route::post('/categories', 'CategoriesController@store');
Route::get('/categories/{category}', 'CategoriesController@show');
Route::get('/categories/{category}/edit', 'CategoriesController@edit');
Route::patch('/categories/{category}', 'CategoriesController@update');
Route::delete('/categories/{category}', 'CategoriesController@destroy');

/**
 * Extra Rate routes
 */
Route::get('/extrarates', 'ExtraRatesController@index');
Route::get('/extrarates/create', 'ExtraRatesController@create');
Route::post('/extrarates', 'ExtraRatesController@store');
Route::get('/extrarates/{extrarate}', 'ExtraRatesController@show');
Route::get('/extrarates/{extrarate}/edit', 'ExtraRatesController@edit');
Route::patch('/extrarates/{extrarate}', 'ExtraRatesController@update');
Route::delete('/extrarates/{extrarate}', 'ExtraRatesController@destroy');

/**
 * Article routes
 */
Route::get('/articles', 'ArticlesController@index');
Route::get('/articles/create', 'ArticlesController@create');
Route::post('/articles', 'ArticlesController@store');
Route::get('/articles/{article}', 'ArticlesController@show');
Route::get('/articles/{article}/edit', 'ArticlesController@edit');
Route::patch('/articles/{article}', 'ArticlesController@update');
Route::delete('/articles/{article}', 'ArticlesController@destroy');

/**
 * Document routes
 */
Route::get('/documents', 'DocumentsController@index');
Route::get('/documents/create', 'DocumentsController@create');
Route::post('/documents', 'DocumentsController@store');
Route::get('/documents/{document}', 'DocumentsController@show');
Route::get('/documents/{document}/edit', 'DocumentsController@edit');
Route::patch('/documents/{document}', 'DocumentsController@update');
Route::delete('/documents/{document}', 'DocumentsController@destroy');