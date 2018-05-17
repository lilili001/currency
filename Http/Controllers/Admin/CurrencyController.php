<?php

namespace Modules\Currency\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Currency\Entities\CurrencyRate;
use Modules\Currency\Http\Requests\CreateCurrencyRequest;
use Modules\Currency\Http\Requests\UpdateCurrencyRequest;
use Modules\Currency\Repositories\CurrencyRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Setting;
use DB;
class CurrencyController extends AdminBaseController
{
    /**
     * @var CurrencyRepository
     */
    private $currency;

    public function __construct(CurrencyRepository $currency)
    {
        parent::__construct();

        $this->currency = $currency;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$currencies = $this->currency->all();
        //currency rate search
        //http://api.jisuapi.com/exchange/single?currency=USD&appkey=11b4e2b81a607dce

        try{
            //先比较数据库有哪几种
            $defaultCurrency = Setting::get('currency::default-currency');
            $allowedCurrencies = json_decode( Setting::get('currency::allowed-currencies') );
            $currenciesFromDB = CurrencyRate::all();

            //如果数据库有 直接取数据库的 如果没有则调接口
            if( count( $allowedCurrencies ) == count( $currenciesFromDB ) ){
                $rateList = $currenciesFromDB->toArray();
                $rateList = arrayChangeKey($rateList , "currency_to" );

            }else{

                $url = "http://api.jisuapi.com/exchange/single?currency=USD&appkey=11b4e2b81a607dce";
                $ch = curl_init();
                $timeout = 5;
                curl_setopt ($ch, CURLOPT_URL, "$url");
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)");
                curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $rates = curl_exec($ch);
                $rateList =   (array)( json_decode($rates)->result->list   );
                $rateList = array_only( $rateList ,  $allowedCurrencies  );

                $tmpData = [];

                foreach( $rateList as  $currency => $item ){
                    $tmpData[] = [
                        'currency_from' => $defaultCurrency,
                        'currency_to' => $currency,
                        'rate' => $item->rate,
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

        //dd( $rateList );

        return view('currency::admin.currencies.index', compact('rateList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('currency::admin.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCurrencyRequest $request
     * @return Response
     */
    public function store(CreateCurrencyRequest $request)
    {
        $this->currency->create($request->all());

        return redirect()->route('admin.currency.currency.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('currency::currencies.title.currencies')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CurrencyRate $currency
     * @return Response
     */
    public function edit(CurrencyRate $currency)
    {
        return view('currency::admin.currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CurrencyRate $currency
     * @param  UpdateCurrencyRequest $request
     * @return Response
     */
    public function update(CurrencyRate $currency, UpdateCurrencyRequest $request)
    {
        $this->currency->update($currency, $request->all());

        return redirect()->route('admin.currency.currency.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('currency::currencies.title.currencies')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CurrencyRate $currency
     * @return Response
     */
    public function destroy(CurrencyRate $currency)
    {
        $this->currency->destroy($currency);

        return redirect()->route('admin.currency.currency.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('currency::currencies.title.currencies')]));
    }
}
