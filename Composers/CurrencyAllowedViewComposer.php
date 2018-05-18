<?php

namespace Modules\Currency\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Modules\Core\Foundation\AsgardCms;
use Modules\Currency\Repositories\CurrencyRepository;
use Modules\Currency\Repositories\CurrencySymbolRepository;

class CurrencyAllowedViewComposer
{
    protected $currency;
    protected $currencySymbol;
    /**
     * CurrencyAllowedViewComposer constructor.
     */
    public function __construct(CurrencyRepository $currency )
    {
        $this->currency = $currency;
    }

    public function compose(View $view)
    {
        $currencyList = $this->currency->getRateList();
        $view->with('allowdCurrencies',$currencyList);
    }

}
