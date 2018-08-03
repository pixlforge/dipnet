<?php

use App\User;
use App\Order;
use App\Delivery;
use App\Document;
use App\Mail\InvitationEmail;
use App\Mail\RegistrationEmailConfirmation;
use App\Mail\AdminOrderCompleteNotification;
use App\Mail\CustomerOrderCompleteConfirmation;

/**
 * --------------------------------------------------------------------------------------
 * API ROUTES
 * --------------------------------------------------------------------------------------
 */

Route::prefix('/api')->namespace('Api')->name('api.')->group(function () {

    /**
     * Articles
     */
    Route::prefix('/articles')->namespace('Article')->name('articles.')->group(function () {
        Route::get('/{sort?}', 'ArticleController@index')->name('index');
    });

    /**
     * Businesses
     */
    Route::prefix('/affaires')->namespace('Business')->name('businesses.')->group(function () {
        Route::get('/{sort?}', 'BusinessController@index')->name('index');
    });

    /**
     * Contacts
     */
    Route::prefix('/contacts')->namespace('Contact')->name('contacts.')->group(function () {
        Route::get('/{sort?}', 'ContactController@index')->name('index');
    });

    /**
     * Companies
     */
    Route::prefix('/societes')->namespace('Company')->name('companies.')->group(function () {
        Route::get('/{sort?}', 'CompanyController@index')->name('index');
    });

    /**
     * Deliveries
     */
    Route::prefix('/livraisons')->namespace('Delivery')->name('deliveries.')->group(function () {
        Route::get('/', 'DeliveryController@index')->name('index');
    });

    /**
     * Documents
     */
    Route::prefix('/documents')->namespace('Document')->name('documents.')->group(function () {
        Route::get('/', 'DocumentController@index')->name('index');
    });

    /**
     * Formats
     */
    Route::prefix('/formats')->namespace('Format')->name('formats.')->group(function () {
        Route::get('/{sort?}', 'FormatController@index')->name('index');
    });

    /**
     * Orders
     */
    Route::prefix('/commandes')->namespace('Order')->name('orders.')->group(function () {
        Route::get('/', 'OrderController@index')->name('index');
    });

    /**
     * Tickers
     */
    Route::prefix('/tickers')->namespace('Ticker')->name('tickers.')->group(function () {
        Route::get('/{sort?}', 'TickerController@index')->name('index');

        // Cookies
        Route::name('cookies.')->group(function () {
            Route::post('/cookies', 'TickerCookieController@store')->name('store');
        });
    });

    /**
     * Users
     */
    Route::prefix('/utilisateurs')->namespace('User')->name('users.')->group(function () {
        Route::get('/{sort?}', 'UserController@index')->name('index');
    });
});

/**
 * --------------------------------------------------------------------------------------
 * ADMIN ROUTES
 * --------------------------------------------------------------------------------------
 */

Route::prefix('/admin')->namespace('Admin')->name('admin.')->group(function () {
    
    /**
     * Articles
     */
    Route::prefix('/articles')->namespace('Article')->name('articles.')->group(function () {
        Route::get('/', 'ArticleController@index')->name('index');
        Route::post('/', 'ArticleController@store')->name('store');
        Route::patch('/{article}', 'ArticleController@update')->name('update');
        Route::delete('/{article}', 'ArticleController@destroy')->name('destroy');
    });

    /**
     * Businesses
     */
    Route::prefix('/affaires')->namespace('Business')->name('businesses.')->group(function () {
        Route::get('/', 'BusinessController@index')->name('index');
        Route::post('/', 'BusinessController@store')->name('store');
        Route::patch('/{business}', 'BusinessController@update')->name('update');
        Route::delete('/{business}', 'BusinessController@destroy')->name('destroy');
    });

    /**
     * Companies
     */
    Route::prefix('/societes')->namespace('Company')->name('companies.')->group(function () {
        Route::get('/', 'CompanyController@index')->name('index');
        Route::post('/', 'CompanyController@store')->name('store');
        Route::patch('/{company}', 'CompanyController@update')->name('update');
        Route::delete('/{company}', 'CompanyController@destroy')->name('destroy');
    });

    /**
     * Contacts
     */
    Route::prefix('/contacts')->namespace('Contact')->name('contacts.')->group(function () {
        Route::get('/', 'ContactController@index')->name('index');
        Route::post('/', 'ContactController@store')->name('store');
        Route::patch('/{contact}', 'ContactController@update')->name('update');
        Route::delete('/{contact}', 'ContactController@destroy')->name('destroy');
    });

    /**
     * Formats
     */
    Route::prefix('/formats')->namespace('Format')->name('formats.')->group(function () {
        Route::get('/', 'FormatController@index')->name('index');
        Route::post('/', 'FormatController@store')->name('store');
        Route::patch('/{format}', 'FormatController@update')->name('update');
        Route::delete('/{format}', 'FormatController@destroy')->name('destroy');
    });

    /**
     * Tickers
     */
    Route::prefix('/tickers')->namespace('Ticker')->name('tickers.')->group(function () {
        Route::get('/', 'TickerController@index')->name('index');
        Route::post('/', 'TickerController@store')->name('store');
        Route::patch('/{ticker}', 'TickerController@update')->name('update');
        Route::delete('/{ticker}', 'TickerController@destroy')->name('destroy');
    });

    /**
     * Users
     */
    Route::prefix('/utilisateurs')->namespace('User')->name('users.')->group(function () {
        Route::get('/', 'UserController@index')->name('index');
        Route::post('/', 'UserController@store')->name('store');
        Route::patch('/{user}', 'UserController@update')->name('update');
        Route::delete('/{user}', 'UserController@destroy')->name('destroy');
    });
});

/**
 * Homepage
 */
Route::get('/', 'Order\OrderController@index')->name('index');

/**
 * Auth
 */
Auth::routes();
Route::get('/logout', 'Auth\LogoutController')->name('logout');

/**
 * Account
 */
Route::prefix('/compte')->namespace('Account')->name('account.')->group(function () {
    Route::get('/', 'AccountController@account')->name('account');
    Route::get('/contact', 'AccountController@contact')->name('contact');
    Route::get('/societe', 'AccountController@company')->name('company');
    Route::patch('/mise-a-jour', 'AccountController@update')->name('update');
});

/**
 * Business
 */
Route::prefix('/affaires')->namespace('Business')->name('businesses.')->group(function () {
    Route::get('/', 'BusinessController@index')->name('index');
    Route::post('/', 'BusinessController@store')->name('store');
    Route::get('/{business}/details', 'BusinessController@show')->name('show');
    Route::patch('/{business}', 'BusinessController@update')->name('update');
    // Route::delete('/{business}', 'BusinessController@destroy')->name('destroy');
});

/**
 * Comment
 */
Route::prefix('/commentaires')->namespace('Comment')->name('comments.')->group(function () {
    Route::post('/{business}', 'CommentController@store')->name('store');
});

/**
 * Company
 */
Route::prefix('/societes')->namespace('Company')->name('companies.')->group(function () {
    Route::get('/{company}', 'CompanyController@show')->name('show');

    /**
     * Default Business
     */
    Route::prefix('/parametres/affaire')->name('default.business.')->group(function () {
        Route::post('/{company}', 'CompanyDefaultBusinessController@store')->name('store');
        Route::get('/par-defaut', 'CompanyDefaultBusinessController@edit')->name('edit');
        Route::patch('/{company}', 'CompanyDefaultBusinessController@update')->name('update');
    });
});

/**
 * Contact
 */
Route::prefix('/contacts')->namespace('Contact')->name('contacts.')->group(function () {
    Route::get('/', 'ContactController@index')->name('index');
    Route::post('/', 'ContactController@store')->name('store');
    Route::put('/{contact}', 'ContactController@update')->name('update');
    Route::delete('/{contact}', 'ContactController@destroy')->name('destroy');
});

/**
 * Deliveries
 */
Route::prefix('/livraisons')->namespace('Delivery')->name('deliveries.')->group(function () {
    Route::get('/', 'DeliveryController@index')->name('index');
    Route::post('/', 'DeliveryController@store')->name('store');
    Route::put('/{delivery}', 'DeliveryController@update')->name('update');
    Route::delete('/{delivery}', 'DeliveryController@destroy')->name('destroy');

    /**
     * Receipt
     */
    Route::get('/{delivery}/quittance/voir', 'DeliveryReceiptController@show')->name('receipts.show');

    /**
     * Note
     */
    Route::put('/{delivery}/note', 'DeliveryNoteController@update')->name('note.update');
    Route::delete('/{delivery}/note', 'DeliveryNoteController@destroy')->name('note.destroy');
    Route::patch('/{delivery}/note/admin', 'DeliveryAdminNoteController@update')->name('admin.note.update');
});

/**
 * Documents
 */
Route::prefix('/documents')->namespace('Document')->name('documents.')->group(function () {
    Route::get('/', 'DocumentController@index')->name('index');
    Route::post('/{order}/{delivery}', 'DocumentController@store')->name('store');
    Route::patch('/{order}/{delivery}/{document}', 'DocumentController@update')->name('update');
    Route::delete('/{order}/{delivery}/{document}', 'DocumentController@destroy')->name('destroy');

    /**
     * Clone
     */
    Route::post('/{order}/{delivery}/clone', 'DocumentOptionController@store')->name('clone.options');
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
 * Orders
 */
Route::prefix('/commandes')->namespace('Order')->name('orders.')->group(function () {
    Route::get('/', 'OrderController@index')->name('index');
    Route::get('/{order}/voir', 'OrderController@show')->name('show');
    Route::get('/create', 'OrderController@create')->name('create.start');
    Route::get('/{order}/creer', 'OrderController@create')->name('create.end');
    Route::put('/{order}', 'OrderController@update')->name('update');
    Route::delete('/{order}', 'OrderController@destroy')->name('destroy');

    /**
     * Completion
     */
    Route::name('complete.')->group(function () {
        Route::patch('/{order}/finaliser', 'CompleteOrderController@update')->name('update');
        Route::get('/{order}/finaliser/voir', 'CompleteOrderController@show')->name('show');
    });

    /**
     * Receipt
     */
    Route::get('/{order}/quittance/voir', 'OrderReceiptController@show')->name('receipts.show');

    /**
     * Status
     */
    Route::put('/{order}/statut', 'OrderStatusController@update')->name('status.update');
});

/**
 * Profiles
 */
Route::prefix('/profile')->namespace('Profiles')->name('profile.')->group(function () {
    Route::get('/', 'ProfileController@index')->name('index');
    Route::patch('/{user}', 'ProfileController@update')->name('update');

    /**
     * Avatar
     */
    Route::post('/avatar', 'AvatarController@store')->name('avatar.store');
});

/**
 * Register
 */
Route::prefix('/inscription')->namespace('Auth')->name('register.')->group(function () {
    Route::get('/', 'RegisterController@index')->name('index');
    Route::post('/', 'RegisterController@store')->name('store');

    Route::post('/contact', 'RegisterContactController@store')->name('contact.store');
    Route::post('/contact-only', 'RegisterContactOnlyController@store')->name('contact-only.store');
    Route::post('/company', 'RegisterCompanyController@store')->name('company.store');

    /**
     * Confirmation
     */
    Route::name('confirm.')->group(function () {
        Route::get('/confirmation', 'RegisterConfirmationController@index')->name('index');
        Route::put('/renvoyer', 'RegisterConfirmationController@update')->name('update');
    });
});

/**
 * Search
 */
Route::prefix('/recherche')->namespace('Search')->name('search.')->group(function () {
    Route::post('/', 'SearchController@search')->name('query');
    Route::get('/testing', 'SearchController@testing')->name('testing');
});

/**
 * Mailables
 */
Route::middleware('admin')->group(function () {

    /**
     * User account registration
     */
    Route::get('/mailables/registration', function () {
        $user = factory(User::class)->states('mailable-tests-only')->make();
        return new RegistrationEmailConfirmation($user);
    });

    /**
     * User account invitation
     */
    Route::get('/mailable/invitation', function () {
        $user = factory(User::class)->states('mailable-tests-only')->make();
        return new InvitationEmail($user);
    });
    
    /**
     * User order confirmation
     */
    Route::get('/mailables/order/confirmation', function () {
        $order = factory(Order::class)->create(['status' => 'envoyée']);
        $deliveries = factory(Delivery::class, 3)->create(['order_id' => $order->id]);

        foreach ($deliveries as $delivery) {
            factory(Document::class, 3)->create(['delivery_id' => $delivery->id]);
        }

        return new CustomerOrderCompleteConfirmation($order);
    });

    /**
     * Admin order notification
     */
    Route::get('/mailables/order/notification', function () {
        $order = factory(Order::class)->create(['status' => 'envoyée']);
        $deliveries = factory(Delivery::class, 3)->create(['order_id' => $order->id]);
        
        foreach ($deliveries as $delivery) {
            factory(Document::class, 3)->create([
                'delivery_id' => $delivery->id
            ]);
        }

        return new AdminOrderCompleteNotification($order);
    });
});

/**
 * 404
 */
Route::fallback(function () {
    return response()->view('errors.notfound', [], 404);
});
