<?php

/**
 * Root
 */
Route::get('/', 'OrdersController@index')->name('index');

/**
 * Auth
 */
Auth::routes();

/**
 * Register
 */
Route::prefix('/register')->group(function () {
    Route::get('/', 'Auth\RegisterController@create')->name('register');
    Route::post('/', 'Auth\RegisterController@store');
    Route::put('/contact', 'Auth\RegisterController@updateContact');
    Route::put('/company', 'Auth\RegisterController@updateCompany');
    Route::get('/confirm', 'Auth\RegisterConfirmationController@index')->name('register.confirm');
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
    Route::post('/', 'InviteMemberController@store')->name('invite');
    Route::get('/confirm', 'InviteMemberController@confirm')->name('invite.confirm');
    Route::put('/confirm', 'InviteMemberController@update')->name('invite.update');
});

/**
 * Logout
 */
Route::get('/logout', 'LogoutController');

/**
 * Profiles
 */
Route::prefix('/profile')->group(function () {
    Route::get('/', 'ProfilesController@profile')->name('profile');
    Route::get('/{user}/edit', 'ProfilesController@edit');
    Route::put('/{user}', 'ProfilesController@update');
});

/**
 * Company
 */
Route::prefix('/companies')->group(function () {
    Route::get('/', 'CompaniesController@index')->name('companies');
    Route::post('/', 'CompaniesController@store');
    Route::get('/{company}', 'CompaniesController@show')->name('companies.show');
    Route::put('/{company}', 'CompaniesController@update');
    Route::delete('/{company}', 'CompaniesController@destroy');
    Route::put('/{company}/restore', 'CompaniesController@restore');
});

/**
 * Business
 */
Route::prefix('/businesses')->group(function () {
    Route::get('/', 'BusinessesController@index')->name('businesses');
    Route::post('/', 'BusinessesController@store');
    Route::put('/{business}', 'BusinessesController@update');
    Route::delete('/{business}', 'BusinessesController@destroy');
    Route::put('/{business}/restore', 'BusinessesController@restore');
});

/**
 * Order
 */
Route::prefix('/orders')->group(function () {
    Route::get('/', 'OrdersController@index')->name('orders');
    Route::post('/', 'OrdersController@store');
    Route::put('/{order}', 'OrdersController@update');
    Route::delete('/{order}', 'OrdersController@destroy');
    Route::put('/{order}/restore', 'OrdersController@restore');
});

/**
 * Contact
 */
Route::prefix('/contacts')->group(function () {
    Route::get('/', 'ContactsController@index')->name('contacts');
    Route::post('/', 'ContactsController@store');
    Route::put('/{contact}', 'ContactsController@update');
    Route::delete('/{contact}', 'ContactsController@destroy');
    Route::put('/{contact}/restore', 'ContactsController@restore');
});

/**
 * Delivery
 */
Route::prefix('/deliveries')->group(function () {
    Route::get('/', 'DeliveriesController@index')->name('deliveries');
    Route::post('/', 'DeliveriesController@store');
    Route::put('/{delivery}', 'DeliveriesController@update');
    Route::delete('/{delivery}', 'DeliveriesController@destroy');
    Route::put('/{delivery}/restore', 'DeliveriesController@restore');
});

/**
 * Document
 */
Route::prefix('/documents')->group(function () {
    Route::get('/', 'DocumentsController@index')->name('documents');
    Route::post('/', 'DocumentsController@store');
    Route::put('/{document}', 'DocumentsController@update');
});

/**
 * Format
 */
Route::prefix('/formats')->group(function () {
    Route::get('/', 'FormatsController@index')->name('formats');
    Route::post('/', 'FormatsController@store');
    Route::put('/{format}', 'FormatsController@update');
    Route::delete('/{format}', 'FormatsController@destroy');
    Route::put('/{format}/restore', 'FormatsController@restore');
});

/**
 * Category
 */
Route::prefix('/categories')->group(function () {
    Route::get('/', 'CategoriesController@index')->name('categories');
    Route::post('/', 'CategoriesController@store');
    Route::put('/{category}', 'CategoriesController@update');
    Route::delete('/{category}', 'CategoriesController@destroy');
});

/**
 * Article
 */
Route::prefix('/articles')->group(function () {
    Route::get('/', 'ArticlesController@index')->name('articles');
    Route::post('/', 'ArticlesController@store');
    Route::put('/{article}', 'ArticlesController@update');
    Route::delete('/{article}', 'ArticlesController@destroy');
    Route::put('/{article}/restore', 'ArticlesController@restore');
});

/**
 * User
 */
Route::prefix('/users')->group(function () {
    Route::get('/', 'UsersController@index')->name('users');
    Route::post('/', 'UsersController@store');
    Route::put('/{user}', 'UsersController@update');
    Route::delete('/{user}', 'UsersController@destroy');
    Route::put('/{user}/restore', 'UsersController@restore');
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