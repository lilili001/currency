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
        $rateList = $this->currency->getRateList();
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
