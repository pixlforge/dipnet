<?php

namespace App\Http\ViewComposers;

use App\Ticker;
use Illuminate\View\View;

class TickerComposer
{
    /**
     * @var $ticker
     */
    protected $ticker;

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        if (!$this->ticker) {
            $this->ticker = Ticker::active()->first();
        }

        $view->with('ticker', $this->ticker);
    }
}
