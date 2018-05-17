<?php

namespace Modules\Currency\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Modules\Core\Foundation\AsgardCms;

class CurrencyDefaultListViewComposer
{
    public function compose(View $view)
    {
        $currencyList = DB::table('currency_code')->get();
        $view->with('defaultCurrencyList',$currencyList);
    }
}
