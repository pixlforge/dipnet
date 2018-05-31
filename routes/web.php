<?php

/**
 * Auth
 */
Auth::routes();

/**
 * Api
 */
Route::prefix('/api')->namespace('Api')->group(function () {
    Route::prefix('/articles')->namespace('Article')->group(function () {
        Route::get('/', 'ArticleController@index')->name('api.articles.index');
    });

    Route::prefix('/businesses')->namespace('Business')->group(function () {
        Route::get('/', 'BusinessController@index')->name('api.businesses.index');
    });

    Route::prefix('/contacts')->namespace('Contact')->group(function () {
        Route::get('/', 'ContactController@index')->name('api.contacts.index');
    });

    Route::prefix('/companies')->namespace('Company')->group(function () {
        Route::get('/', 'CompanyController@index')->name('api.companies.index');
    });

    Route::prefix('/deliveries')->namespace('Delivery')->group(function () {
        Route::get('/', 'DeliveryController@index')->name('api.deliveries.index');
    });

    Route::prefix('/documents')->namespace('Document')->group(function () {
        Route::get('/', 'DocumentController@index')->name('api.documents.index');
    });

    Route::prefix('/formats')->namespace('Format')->group(function () {
        Route::get('/', 'FormatController@index')->name('api.formats.index');
    });

    Route::prefix('/orders')->namespace('Order')->group(function () {
        Route::get('/', 'OrderController@index')->name('api.orders.index');
    });

    Route::prefix('/tickers')->namespace('Ticker')->group(function () {
        Route::get('/', 'TickerController@index')->name('api.tickers.index');

        // Cookies
        Route::post('/cookies', 'TickerCookieController@store')->name('api.tickers.cookies.store');
    });

    Route::prefix('/users')->namespace('User')->group(function () {
        Route::get('/', 'UserController@index')->name('api.users.index');
    });
});

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
    Route::get('/create', 'BusinessController@create')->name('businesses.create');
    Route::post('/', 'BusinessController@store')->name('businesses.store');
    Route::get('/{business}/show', 'BusinessController@show')->name('businesses.show');
    Route::put('/{business}', 'BusinessController@update')->name('businesses.update');
    Route::delete('/{business}', 'BusinessController@destroy')->name('businesses.destroy');
});

/**
 * Comment
 */
Route::prefix('/comments')->namespace('Comment')->group(function () {
    Route::post('/{business}', 'CommentController@store')->name('comments.store');
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

    Route::get('/{delivery}/receipt/show', 'DeliveryReceiptController@show')->name('deliveries.receipts.show');

    /**
     * Note
     */
    Route::put('/{delivery}/note', 'DeliveryNoteController@update')->name('deliveries.note.update');
    Route::delete('/{delivery}/note', 'DeliveryNoteController@destroy')->name('deliveries.note.destroy');
    Route::patch('/{delivery}/note/admin', 'DeliveryAdminNoteController@update')->name('deliveries.admin.note.update');
});

/**
 * Order validation
 */
Route::prefix('/orders')->namespace('Order')->group(function () {
    Route::post('/{order}/validation', 'OrderValidationController@validation')->name('orders.validation');
});

/**
 * Documents
 */
Route::prefix('/documents')->namespace('Document')->group(function () {
    Route::get('/', 'DocumentController@index')->name('documents.index');
});

Route::prefix('/orders')->namespace('Document')->group(function () {
    Route::post('/{order}/{delivery}', 'DocumentController@store')->name('documents.store');
    Route::patch('/{order}/{delivery}/{document}', 'DocumentController@update')->name('documents.update');
    Route::delete('/{order}/{delivery}/{document}', 'DocumentController@destroy')->name('documents.destroy');
    Route::post('/{order}/{delivery}/clone', 'DocumentOptionController@store')->name('documents.clone.options');
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
    Route::get('/{order}/show', 'OrderController@show')->name('orders.show');
    Route::get('/create', 'OrderController@create')->name('orders.create.start');
    Route::get('/{order}/create', 'OrderController@create')->name('orders.create.end');
    Route::put('/{order}', 'OrderController@update')->name('orders.update');
    Route::delete('/{order}', 'OrderController@destroy')->name('orders.destroy');
    Route::patch('/{order}/complete', 'CompleteOrderController@update')->name('orders.complete');
    Route::get('/{order}/complete/show', 'CompleteOrderController@show')->name('orders.complete.show');

    Route::get('/{order}/receipt/show', 'OrderReceiptController@show')->name('orders.receipts.show');
    Route::put('/{order}/status', 'OrderStatusController@update')->name('orders.status.update');
});

/**
 * Profiles
 */
Route::prefix('/profile')->namespace('Profiles')->group(function () {
    Route::get('/', 'ProfileController@index')->name('profile.index');
    Route::patch('/{user}', 'ProfileController@update')->name('profile.update');

    /**
     * Avatar
     */
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
 * Ticker
 */
Route::prefix('/ticker')->namespace('Ticker')->group(function () {
    Route::get('/', 'TickerController@index')->name('tickers.index');
    Route::post('/', 'TickerController@store')->name('tickers.store');
    Route::put('/{ticker}', 'TickerController@update')->name('tickers.update');
    Route::delete('/{ticker}', 'TickerController@destroy')->name('tickers.destroy');
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
 * Mailables
 */
Route::middleware(['admin'])->group(function () {
    /**
     * Customer confirmation email.
     */
    Route::get('/mailables/order/confirmation', function () {
        $order = factory(\Dipnet\Order::class)->create([
            'status' => 'envoyée'
        ]);

        $deliveries = factory(\Dipnet\Delivery::class, 3)->create([
            'order_id' => $order->id
        ]);

        foreach ($deliveries as $delivery) {
            factory(\Dipnet\Document::class, 3)->create([
                'delivery_id' => $delivery->id
            ]);
        }

        return new \Dipnet\Mail\CustomerOrderCompleteConfirmation($order);
    });

    /**
     * Admin order notification.
     */
    Route::get('/mailables/order/notification', function () {
        $order = factory(\Dipnet\Order::class)->create([
            'status' => 'envoyée'
        ]);

        $deliveries = factory(\Dipnet\Delivery::class, 3)->create([
            'order_id' => $order->id
        ]);

        foreach ($deliveries as $delivery) {
            factory(\Dipnet\Document::class, 3)->create([
                'delivery_id' => $delivery->id
            ]);
        }

        return new \Dipnet\Mail\AdminOrderCompleteNotification($order);
    });
});

/**
 * Errors
 */
Route::fallback(function () {
    return response()->view('errors.notfound', [], 404);
});
