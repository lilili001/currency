<?php

namespace Modules\Currency\Repositories\Eloquent;

use Modules\Currency\Repositories\CurrencySymbolRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Currency\Entities\CurrencySymbol;
use Setting;
use DB;
class EloquentCurrencySymbolRepository extends EloquentBaseRepository implements CurrencySymbolRepository
{
    public function all()
    {
        //先比较数据库有哪几种
        $defaultCurrency = Setting::get('currency::default-currency');
        $allowedCurrencies = json_decode( Setting::get('currency::allowed-currencies') );

        //如果数据库有 直接取数据库的 如果没有则调接口
        //从currency_code表取
        $temp=[];
        foreach ( $allowedCurrencies as $item ){
            //check db
            $fromDb = CurrencySymbol::where('currency',$item)->get() ;

            $temp[$item] = count( $fromDb ) > 0 ? $fromDb->first() :  DB::table('currency_code')->where('code',$item)->get()->first() ;
        }
        $currencySymbol =   $temp;

        return $currencySymbol;
    }
}
