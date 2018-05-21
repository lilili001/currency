<?php

namespace Modules\Currency\Repositories\Eloquent;

use Carbon\Carbon;
use Modules\Currency\Entities\CurrencyCode;
use Modules\Currency\Entities\CurrencyRate;
use Modules\Currency\Repositories\CurrencyRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use DB;
use Setting;
class EloquentCurrencyRepository extends EloquentBaseRepository implements CurrencyRepository
{
    public function getRateList()
    {
        try{
            //先比较数据库有哪几种
            $defaultCurrency = Setting::get('currency::default-currency');
            $allowedCurrencies = json_decode( Setting::get('currency::allowed-currencies') );
            $currenciesFromDB = CurrencyRate::all();

            info( count( $allowedCurrencies ) );
            info( count( $currenciesFromDB ) );

            //如果数据库有 直接取数据库的 如果没有则调接口
            if( count( $allowedCurrencies ) == count( $currenciesFromDB ) ){
                $rateList = $currenciesFromDB->toArray();
                $rateList = arrayChangeKey($rateList , "currency_to" );

            }else{

                info('数据库没有的情况,默认取数据库,可以开启定时任务获取实时货币');

                $url = "http://api.jisuapi.com/exchange/single?currency=USD&appkey=".env('CURRENCY_APP_KEY');
                $ch = curl_init();
                $timeout = 5;
                curl_setopt ($ch, CURLOPT_URL, "$url");
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)");
                curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $rates = curl_exec($ch);

                $rateList =   (array)( json_decode($rates)->result->list   );

                //更新currency_code 表 将汇率存进表里
                $currency_code_items = CurrencyCode::all();
                foreach ( $currency_code_items as $row ){
                    if( isset( $rateList[ $row->code ] ) ){
                        $row->update([
                            'rate' => ($rateList[ $row->code ])->rate
                        ]);
                    }
                }
                $tmpData = [];
                foreach( $allowedCurrencies as $currency_code ){
                    $currency_to = $currency_code == $defaultCurrency ? $defaultCurrency : $currency_code;
                    $rate = $currency_code == $defaultCurrency ? 1 : $rateList[$currency_code]->rate;

                    $currency_org = CurrencyCode::where('code' ,$currency_code )->get()->first();

                    //currency_code中的对象
                    $currencyCodeItem = CurrencyCode::where( 'code' , $currency_code )->get()->first();
                        $tmpData[] = [
                            'currency_from' => $defaultCurrency,
                            'currency_to' => $currency_to,
                            'rate' => $rate,
                            'symbol' =>  isset( $currency_org->symbol ) ? $currencyCodeItem->symbol : ''  ,
                            'created_at' => Carbon::now(),
                            'updated_at' =>  Carbon::now()
                        ];
                }

                CurrencyRate::truncate();
                DB::table('currency__currencies_rate')->insert($tmpData);
                curl_close($ch);
                //最终还是取数据库的
                $currenciesFromDB = CurrencyRate::all();
                $rateList = $currenciesFromDB->toArray();
                $rateList = arrayChangeKey($rateList , "currency_to" );
            }
        }catch (Exception $e){
            return $e->getMessage();
        }
        return $rateList;
    }
}
