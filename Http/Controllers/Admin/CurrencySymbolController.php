<?php

namespace Modules\Currency\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Currency\Entities\CurrencySymbol;
use Modules\Currency\Http\Requests\CreateCurrencySymbolRequest;
use Modules\Currency\Http\Requests\UpdateCurrencySymbolRequest;
use Modules\Currency\Repositories\CurrencySymbolRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CurrencySymbolController extends AdminBaseController
{
    /**
     * @var CurrencySymbolRepository
     */
    private $currencysymbol;

    public function __construct(CurrencySymbolRepository $currencysymbol)
    {
        parent::__construct();

        $this->currencysymbol = $currencysymbol;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$currencysymbols = $this->currencysymbol->all();

        return view('currency::admin.currencysymbols.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('currency::admin.currencysymbols.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCurrencySymbolRequest $request
     * @return Response
     */
    public function store(CreateCurrencySymbolRequest $request)
    {
        $this->currencysymbol->create($request->all());

        return redirect()->route('admin.currency.currencysymbol.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('currency::currencysymbols.title.currencysymbols')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CurrencySymbol $currencysymbol
     * @return Response
     */
    public function edit(CurrencySymbol $currencysymbol)
    {
        return view('currency::admin.currencysymbols.edit', compact('currencysymbol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CurrencySymbol $currencysymbol
     * @param  UpdateCurrencySymbolRequest $request
     * @return Response
     */
    public function update(CurrencySymbol $currencysymbol, UpdateCurrencySymbolRequest $request)
    {
        $this->currencysymbol->update($currencysymbol, $request->all());

        return redirect()->route('admin.currency.currencysymbol.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('currency::currencysymbols.title.currencysymbols')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CurrencySymbol $currencysymbol
     * @return Response
     */
    public function destroy(CurrencySymbol $currencysymbol)
    {
        $this->currencysymbol->destroy($currencysymbol);

        return redirect()->route('admin.currency.currencysymbol.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('currency::currencysymbols.title.currencysymbols')]));
    }
}
