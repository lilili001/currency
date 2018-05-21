<?php

namespace Modules\Currency\Http\Controllers\Api;

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
use AjaxResponse;
class ApiController extends AdminBaseController
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

    public function switchCurrency ($currencyCode)
    {
        $tmpdata = json_encode( array( $currencyCode ) );

        try{
            $bool = DB::table('setting__settings')->where('name','currency::current-currency')->update([
                'plainValue' =>  $tmpdata
            ]);
        }catch (Exception $e){
            return AjaxResponse::response('fail',$e->getMessage());
        }

        return response()->json(['result' => $bool]);
    }
}
