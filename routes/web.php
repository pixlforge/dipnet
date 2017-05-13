<?php

/**
 * Basic routes
 */
Route::get('/', 'PageController@welcome');
Route::get('/index', 'PageController@index')->name('home');

/**
 * User routes
 */
Route::get('/user', 'UserController@index');
Route::get('/user/create', 'UserController@create');
Route::post('/user', 'UserController@store');
Route::get('/user/{user}', 'UserController@show');
Route::get('/user/{user}/edit', 'UserController@edit');
Route::patch('/user/{user}', 'UserController@update');
Route::delete('/user/{user}', 'UserController@destroy');

/**
 * Business routes
 */
Route::get('/business', 'BusinessController@index');
Route::get('/business/create', 'BusinessController@create');
Route::post('/business', 'BusinessController@store');
Route::get('/business/{business}', 'BusinessController@show');
Route::get('/business/{business}/edit', 'BusinessController@edit');
Route::patch('/business/{business}', 'BusinessController@update');
Route::delete('/business/{business}', 'BusinessController@destroy');

/**
 * Company routes
 */
Route::get('/company', 'CompanyController@index');
Route::get('/company/create', 'CompanyController@create');
Route::post('/company', 'CompanyController@store');
Route::get('/company/{company}', 'CompanyController@show');
Route::get('/company/{company}/edit', 'CompanyController@edit');
Route::patch('/company/{company}', 'CompanyController@update');
Route::delete('/company/{company}', 'CompanyController@destroy');

/**
 * Contact routes
 */
Route::get('/contact', 'ContactController@index');
Route::get('/contact/create', 'ContactController@create');
Route::post('/contact', 'ContactController@store');
Route::get('/contact/{contact}', 'ContactController@show');
Route::get('/contact/{contact}/edit', 'ContactController@edit');
Route::patch('/contact/{contact}', 'ContactController@update');
Route::delete('/contact/{contact}', 'ContactController@destroy');

/**
 * Order routes
 */
Route::get('/order', 'OrderController@index');
Route::get('/order/create', 'OrderController@create');
Route::post('/order', 'OrderController@store');
Route::get('/order/{order}', 'OrderController@show');
Route::get('/order/{order}/edit', 'OrderController@edit');
Route::patch('/order/{order}', 'OrderController@update');
Route::delete('/order/{order}', 'OrderController@destroy');

/**
 * Format routes
 */
Route::get('/format', 'FormatController@index');
Route::get('/format/create', 'FormatController@create');
Route::post('/format', 'FormatController@store');
Route::get('/format/{format}', 'FormatController@show');
Route::get('/format/{format}/edit', 'FormatController@edit');
Route::patch('/format/{format}', 'FormatController@update');
Route::delete('/format/{format}', 'FormatController@destroy');

/**
 * Category routes
 */
Route::get('/category', 'CategoryController@index');
Route::get('/category/create', 'CategoryController@create');
Route::post('/category', 'CategoryController@store');
Route::get('/category/{category}', 'CategoryController@show');
Route::get('/category/{category}/edit', 'CategoryController@edit');
Route::patch('/category/{category}', 'CategoryController@update');
Route::delete('/category/{category}', 'CategoryController@destroy');

/**
 * Extra Rate routes
 */
Route::get('/extrarate', 'ExtraRateController@index');
Route::get('/extrarate/create', 'ExtraRateController@create');
Route::post('/extrarate', 'ExtraRateController@store');
Route::get('/extrarate/{extrarate}', 'ExtraRateController@show');
Route::get('/extrarate/{extrarate}/edit', 'ExtraRateController@edit');
Route::patch('/extrarate/{extrarate}', 'ExtraRateController@update');
Route::delete('/extrarate/{extrarate}', 'ExtraRateController@destroy');

/**
 * Article routes
 */
Route::get('/article', 'ArticleController@index');
Route::get('/article/create', 'ArticleController@create');
Route::post('/article', 'ArticleController@store');
Route::get('/article/{article}', 'ArticleController@show');
Route::get('/article/{article}/edit', 'ArticleController@edit');
Route::patch('/article/{article}', 'ArticleController@update');
Route::delete('/article/{article}', 'ArticleController@destroy');

/**
 * Document routes
 */
Route::get('/document', 'DocumentController@index');
Route::get('/document/create', 'DocumentController@create');
Route::post('/document', 'DocumentController@store');
Route::get('/document/{document}', 'DocumentController@show');
Route::get('/document/{document}/edit', 'DocumentController@edit');
Route::patch('/document/{document}', 'DocumentController@update');
Route::delete('/document/{document}', 'DocumentController@destroy');

/**
 * Delivery routes
 */
Route::get('/delivery', 'DeliveryController@index');
Route::get('/delivery/create', 'DeliveryController@create');
Route::post('/delivery', 'DeliveryController@store');
Route::get('/delivery/{delivery}', 'DeliveryController@show');
Route::get('/delivery/{delivery}/edit', 'DeliveryController@edit');
Route::patch('/delivery/{delivery}', 'DeliveryController@update');
Route::delete('/delivery/{delivery}', 'DeliveryController@destroy');