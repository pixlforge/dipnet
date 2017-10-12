<?php

/**
 * Account
 */
Route::prefix('/account')->namespace('Account')->group(function () {
    Route::get('/', 'AccountController@account')->name('account.account');
    Route::get('/contact', 'AccountController@contact')->name('account.contact');
    Route::get('/company', 'AccountController@company')->name('account.company');
    Route::patch('/update', 'AccountController@update')->name('account.update');
});

/**
 * Articles
 */
Route::prefix('/articles')->namespace('Articles')->group(function () {
    Route::get('/', 'ArticlesController@index')->name('articles.index');
    Route::post('/', 'ArticlesController@store')->name('articles.store');
    Route::put('/{article}', 'ArticlesController@update')->name('articles.update');
    Route::delete('/{article}', 'ArticlesController@destroy')->name('articles.destroy');
});

/**
 * Auth
 */
Auth::routes();

/**
 * Businesses
 */
Route::prefix('/businesses')->namespace('Businesses')->group(function () {
    Route::get('/', 'BusinessesController@index')->name('businesses.index');
    Route::post('/', 'BusinessesController@store')->name('businesses.store');
    Route::put('/{business}', 'BusinessesController@update')->name('businesses.update');
    Route::delete('/{business}', 'BusinessesController@destroy')->name('businesses.destroy');
});

/**
 * Categories
 */
Route::prefix('/categories')->namespace('Categories')->group(function () {
    Route::get('/', 'CategoriesController@index')->name('categories.index');
    Route::post('/', 'CategoriesController@store')->name('categories.store');
    Route::put('/{category}', 'CategoriesController@update')->name('categories.update');
    Route::delete('/{category}', 'CategoriesController@destroy')->name('categories.destroy');
});

/**
 * Companies
 */
Route::prefix('/companies')->namespace('Companies')->group(function () {
    Route::get('/', 'CompaniesController@index')->name('companies.index');
    Route::post('/', 'CompaniesController@store')->name('companies.store');
    Route::get('/{company}', 'CompaniesController@show')->name('companies.show');
    Route::put('/{company}', 'CompaniesController@update')->name('companies.update');
    Route::delete('/{company}', 'CompaniesController@destroy')->name('companies.destroy');
});

/**
 * Contacts
 */
Route::prefix('/contacts')->namespace('Contacts')->group(function () {
    Route::get('/', 'ContactsController@index')->name('contacts.index');
    Route::post('/', 'ContactsController@store')->name('contacts.store');
    Route::put('/{contact}', 'ContactsController@update')->name('contacts.update');
    Route::delete('/{contact}', 'ContactsController@destroy')->name('contacts.destroy');
});

/**
 * Deliveries
 */
Route::prefix('/deliveries')->namespace('Deliveries')->group(function () {
    Route::get('/', 'DeliveriesController@index')->name('deliveries.index');
    Route::post('/', 'DeliveriesController@store')->name('deliveries.store');
    Route::put('/{delivery}', 'DeliveriesController@update')->name('deliveries.update');
    Route::delete('/{delivery}', 'DeliveriesController@destroy')->name('deliveries.destroy');
});

/**
 * Documents
 */
Route::prefix('/documents')->namespace('Documents')->group(function () {
    Route::get('/', 'DocumentsController@index')->name('documents.index');
    Route::post('/', 'DocumentsController@store')->name('documents.store');
    Route::put('/{document}', 'DocumentsController@update')->name('documents.update');
});

/**
 * Formats
 */
Route::prefix('/formats')->namespace('Formats')->group(function () {
    Route::get('/', 'FormatsController@index')->name('formats.index');
    Route::post('/', 'FormatsController@store')->name('formats.store');
    Route::put('/{format}', 'FormatsController@update')->name('formats.update');
    Route::delete('/{format}', 'FormatsController@destroy')->name('formats.destroy');
});

/**
 * Invitations
 */
Route::prefix('/invitation')->namespace('Invitations')->group(function () {
    Route::post('/', 'InvitationsController@store')->name('invitation.store');
    Route::put('/', 'InvitationsController@update')->name('invitation.update');
    Route::post('/confirm', 'InvitationsController@confirm')->name('invitation.confirm');
    Route::delete('/{invitation}', 'InvitationsController@destroy')->name('invitation.destroy');
});

/**
 * Logout
 */
Route::get('/logout', 'Auth\LogoutController')->name('logout');

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

/**
 * Orders
 */
Route::prefix('/orders')->namespace('Orders')->group(function () {
    Route::get('/', 'OrdersController@index')->name('orders.index');
    Route::post('/', 'OrdersController@store')->name('orders.store');
    Route::put('/{order}', 'OrdersController@update')->name('orders.update');
    Route::delete('/{order}', 'OrdersController@destroy')->name('orders.destroy');
});

/**
 * Profiles
 */
Route::prefix('/profile')->namespace('Profiles')->group(function () {
    Route::get('/', 'ProfileController@index')->name('profile.index');
    Route::patch('/{user}', 'ProfileController@update')->name('profile.update');

    Route::post('/avatar', 'AvatarController@store')->name('profile.avatar.store');
});

/**
 * Register
 */
Route::prefix('/register')->namespace('Auth')->group(function () {
    Route::get('/', 'RegisterController@index')->name('register.index');
    Route::post('/', 'RegisterController@store')->name('register.store');

    Route::post('/contact', 'RegisterContactController@store')->name('register.contact.store');
    Route::post('/contact-only', 'RegisterContactOnlyController@store')->name('register.contact-only.store');
    Route::post('/company', 'RegisterCompanyController@store')->name('register.company.store');

    Route::get('/confirm', 'RegisterConfirmationController@index')->name('register.confirm');
    Route::put('/send-again', 'RegisterConfirmationController@update')->name('register.confirm.update');
});

/**
 * Root
 */
Route::get('/', 'Orders\OrdersController@index')->name('index');

/**
 * Search
 */
Route::prefix('/search')->namespace('Search')->group(function () {
    Route::post('/', 'SearchController@search')->name('search.query');
    Route::get('/testing', 'SearchController@testing')->name('search.testing');
});

/**
 * User
 */
Route::prefix('/users')->namespace('Users')->group(function () {
    Route::get('/', 'UsersController@index')->name('users.index');
    Route::post('/', 'UsersController@store')->name('users.store');
    Route::put('/{user}', 'UsersController@update')->name('users.update');
    Route::delete('/{user}', 'UsersController@destroy')->name('users.destroy');
});

/**
 * Errors
 */
Route::fallback(function () {
    return response()->view('errors.notfound', [], 404);
});