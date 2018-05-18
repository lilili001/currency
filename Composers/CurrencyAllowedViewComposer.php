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
//    public function __construct(CurrencyRepository $currency, CurrencySymbolRepository $currencySymbol)
//    {
//        $this->currency = $currency;
//        $this->currencySymbol = $currencySymbol;
//    }
//
//    public function compose(View $view)
//    {
//        $currencyList = $this->currency->getRateList();
//        $currencySymbo = $this->currencySymbol->all();
//         array_map(function($item)use( $currencySymbo ){
//           $currencyTo = $item->currency_to;
//           $item['symbol'] = $currencySymbo[$currencyTo];
//         } ,$currencyList );
//        $view->with('allowdCurrencies',compact('currencyList'));
//    }
    public function compose(View $view)
    {
        $a = 'alice';
        $view->with('allowdCurrencies' , $a  );
    }
}
