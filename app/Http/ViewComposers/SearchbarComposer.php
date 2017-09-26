<?php

namespace App\Http\ViewComposers;

use App\Contact;
use App\Order;
use Illuminate\View\View;

class SearchbarComposer
{
    public function compose(View $view)
    {
        $view->with([
            'orders' => Order::all(),
            'contacts' => Contact::all()
        ]);
    }
}