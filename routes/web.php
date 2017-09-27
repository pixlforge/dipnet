<?php

/**
 * Root
 */
Route::get('/', 'OrdersController@index')->name('index');
Route::fallback(function () {
    return response()->view('errors.notfound', [], 404);
});

/**
 * Auth
 */
Auth::routes();

/**
 * Register
 */
Route::prefix('/register')->namespace('Auth')->group(function () {
    Route::get('/', 'RegisterController@create')->name('register');
    Route::post('/', 'RegisterController@store');
    Route::put('/contact', 'RegisterController@updateContact');
    Route::put('/company', 'RegisterController@updateCompany');
    Route::get('/confirm', 'RegisterConfirmationController@index')->name('register.confirm');
});

/**
 * Account
 */
Route::prefix('/account')->group(function () {
    Route::get('/', 'AccountController@account')->name('account');
    Route::get('/contact', 'AccountController@contact')->name('account.contact');
    Route::get('/company', 'AccountController@company')->name('account.company');
});

/**
 * Invitation
 */
Route::prefix('/invite')->group(function () {
    Route::post('/', 'InviteMemberController@store')->name('invite.store');
    Route::get('/confirm', 'InviteMemberController@confirm')->name('invite.confirm');
    Route::put('/confirm', 'InviteMemberController@update')->name('invite.update');
});

/**
 * Logout
 */
Route::get('/logout', 'LogoutController')->name('logout');

/**
 * Profiles
 */
Route::prefix('/profile')->group(function () {
    Route::get('/', 'ProfilesController@profile')->name('profile');
    Route::get('/{user}/edit', 'ProfilesController@edit');
    Route::put('/{user}', 'ProfilesController@update');
});

/**
 * Search
 */
Route::prefix('/search')->namespace('Search')->group(function () {
    Route::post('/', 'SearchController@search')->name('search.query');
});

/**
 * Company
 */
Route::prefix('/companies')->group(function () {
    Route::get('/', 'CompaniesController@index')->name('companies.index');
    Route::post('/', 'CompaniesController@store')->name('companies.store');
    Route::get('/{company}', 'CompaniesController@show')->name('companies.show');
    Route::put('/{company}', 'CompaniesController@update')->name('companies.update');
    Route::delete('/{company}', 'CompaniesController@destroy')->name('companies.destroy');
});

/**
 * Business
 */
Route::prefix('/businesses')->group(function () {
    Route::get('/', 'BusinessesController@index')->name('businesses.index');
    Route::post('/', 'BusinessesController@store')->name('businesses.store');
    Route::put('/{business}', 'BusinessesController@update')->name('businesses.update');
    Route::delete('/{business}', 'BusinessesController@destroy')->name('businesses.destroy');
});

/**
 * Order
 */
Route::prefix('/orders')->group(function () {
    Route::get('/', 'OrdersController@index')->name('orders.index');
    Route::post('/', 'OrdersController@store')->name('orders.store');
    Route::put('/{order}', 'OrdersController@update')->name('orders.update');
    Route::delete('/{order}', 'OrdersController@destroy')->name('orders.destroy');
});

/**
 * Contact
 */
Route::prefix('/contacts')->group(function () {
    Route::get('/', 'ContactsController@index')->name('contacts.index');
    Route::post('/', 'ContactsController@store')->name('contacts.store');
    Route::put('/{contact}', 'ContactsController@update')->name('contacts.update');
    Route::delete('/{contact}', 'ContactsController@destroy')->name('contacts.destroy');
});

/**
 * Delivery
 */
Route::prefix('/deliveries')->group(function () {
    Route::get('/', 'DeliveriesController@index')->name('deliveries.index');
    Route::post('/', 'DeliveriesController@store')->name('deliveries.store');
    Route::put('/{delivery}', 'DeliveriesController@update')->name('deliveries.update');
    Route::delete('/{delivery}', 'DeliveriesController@destroy')->name('deliveries.destroy');
});

/**
 * Document
 */
Route::prefix('/documents')->group(function () {
    Route::get('/', 'DocumentsController@index')->name('documents.index');
    Route::post('/', 'DocumentsController@store')->name('documents.store');
    Route::put('/{document}', 'DocumentsController@update')->name('documents.update');
});

/**
 * Format
 */
Route::prefix('/formats')->group(function () {
    Route::get('/', 'FormatsController@index')->name('formats.index');
    Route::post('/', 'FormatsController@store')->name('formats.store');
    Route::put('/{format}', 'FormatsController@update')->name('formats.update');
    Route::delete('/{format}', 'FormatsController@destroy')->name('formats.destroy');
});

/**
 * Category
 */
Route::prefix('/categories')->group(function () {
    Route::get('/', 'CategoriesController@index')->name('categories.index');
    Route::post('/', 'CategoriesController@store')->name('categories.store');
    Route::put('/{category}', 'CategoriesController@update')->name('categories.update');
    Route::delete('/{category}', 'CategoriesController@destroy')->name('categories.destroy');
});

/**
 * Article
 */
Route::prefix('/articles')->group(function () {
    Route::get('/', 'ArticlesController@index')->name('articles.index');
    Route::post('/', 'ArticlesController@store')->name('articles.store');
    Route::put('/{article}', 'ArticlesController@update')->name('articles.update');
    Route::delete('/{article}', 'ArticlesController@destroy')->name('articles.destroy');
});

/**
 * User
 */
Route::prefix('/users')->group(function () {
    Route::get('/', 'UsersController@index')->name('users.index');
    Route::post('/', 'UsersController@store')->name('users.store');
    Route::put('/{user}', 'UsersController@update')->name('users.update');
    Route::delete('/{user}', 'UsersController@destroy')->name('users.destroy');
});

/**
 * Mailables
 */
Route::get('/mailable/registration', function () {
    $user = factory('App\User')->states('mailable-tests-only')->make();
    return new \App\Mail\RegistrationEmailConfirmation($user);
});
Route::get('/mailable/invitation', function () {
    $user = factory('App\User')->states('mailable-tests-only')->make();
    return new \App\Mail\InvitationEmail($user);
});