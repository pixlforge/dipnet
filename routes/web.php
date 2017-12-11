<?php

/**
 * Auth
 */
Auth::routes();

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
 * Article
 */
Route::prefix('/articles')->namespace('Article')->group(function () {
    Route::get('/', 'ArticleController@index')->name('articles.index');
    Route::post('/', 'ArticleController@store')->name('articles.store');
    Route::put('/{article}', 'ArticleController@update')->name('articles.update');
    Route::delete('/{article}', 'ArticleController@destroy')->name('articles.destroy');
});

/**
 * Business
 */
Route::prefix('/businesses')->namespace('Business')->group(function () {
    Route::get('/', 'BusinessController@index')->name('businesses.index');
    Route::post('/', 'BusinessController@store')->name('businesses.store');
    Route::put('/{business}', 'BusinessController@update')->name('businesses.update');
    Route::delete('/{business}', 'BusinessController@destroy')->name('businesses.destroy');
});

/**
 * Company
 */
Route::prefix('/companies')->namespace('Company')->group(function () {
    Route::get('/', 'CompanyController@index')->name('companies.index');
    Route::post('/', 'CompanyController@store')->name('companies.store');
    Route::get('/{company}', 'CompanyController@show')->name('companies.show');
    Route::put('/{company}', 'CompanyController@update')->name('companies.update');
    Route::delete('/{company}', 'CompanyController@destroy')->name('companies.destroy');
});

/**
 * Contact
 */
Route::prefix('/contacts')->namespace('Contact')->group(function () {
    Route::get('/', 'ContactController@index')->name('contacts.index');
    Route::post('/', 'ContactController@store')->name('contacts.store');
    Route::put('/{contact}', 'ContactController@update')->name('contacts.update');
    Route::delete('/{contact}', 'ContactController@destroy')->name('contacts.destroy');
});

/**
 * Deliveries
 */
Route::prefix('/deliveries')->namespace('Delivery')->group(function () {
    Route::get('/', 'DeliveryController@index')->name('deliveries.index');
    Route::post('/', 'DeliveryController@store')->name('deliveries.store');
    Route::put('/{delivery}', 'DeliveryController@update')->name('deliveries.update');
    Route::delete('/{delivery}', 'DeliveryController@destroy')->name('deliveries.destroy');

    /**
     * Note
     */
    Route::put('/{delivery}/note', 'DeliveryNoteController@update')->name('deliveries.note.update');
    Route::delete('/{delivery}/note', 'DeliveryNoteController@destroy')->name('deliveries.note.destroy');
});

/**
 * Documents
 */
Route::prefix('/documents')->namespace('Document')->group(function () {
    Route::get('/', 'DocumentController@index')->name('documents.index');
});

Route::prefix('/orders')->namespace('Document')->group(function () {
    Route::post('/{order}/{delivery}', 'DocumentController@store')->name('documents.store');
//    Route::patch('/{order}/{delivery}/{document}', 'DocumentController@update')->name('documents.update');
    Route::delete('/{order}/{delivery}/{document}', 'DocumentController@destroy')->name('documents.destroy');
});


/**
 * Formats
 */
Route::prefix('/formats')->namespace('Format')->group(function () {
    Route::get('/', 'FormatController@index')->name('formats.index');
    Route::post('/', 'FormatController@store')->name('formats.store');
    Route::put('/{format}', 'FormatController@update')->name('formats.update');
    Route::delete('/{format}', 'FormatController@destroy')->name('formats.destroy');
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
Route::prefix('/orders')->namespace('Order')->group(function () {
    Route::get('/', 'OrderController@index')->name('orders.index');
    Route::get('/create', 'OrderController@create')->name('orders.create.start');
    Route::get('/{order}/create', 'OrderController@create')->name('orders.create.end');
    Route::put('/{order}', 'OrderController@update')->name('orders.update');
    Route::delete('/{order}', 'OrderController@destroy')->name('orders.destroy');
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
Route::get('/', 'Order\OrderController@index')->name('index');

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
Route::prefix('/users')->namespace('User')->group(function () {
    Route::get('/', 'UserController@index')->name('users.index');
    Route::post('/', 'UserController@store')->name('users.store');
    Route::put('/{user}', 'UserController@update')->name('users.update');
    Route::delete('/{user}', 'UserController@destroy')->name('users.destroy');
});

/**
 * Errors
 */
Route::fallback(function () {
    return response()->view('errors.notfound', [], 404);
});