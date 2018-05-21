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
use AjaxResponse;
class PublicController extends AdminBaseController
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

    public function switchCurrency($currency)
    {
       return $currency;
    }
}
