<?php

namespace Modules\Currency\Repositories\Cache;

use Modules\Currency\Repositories\CurrencySymbolRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCurrencySymbolDecorator extends BaseCacheDecorator implements CurrencySymbolRepository
{
    public function __construct(CurrencySymbolRepository $currencysymbol)
    {
        parent::__construct();
        $this->entityName = 'currency.currencysymbols';
        $this->repository = $currencysymbol;
    }
}
