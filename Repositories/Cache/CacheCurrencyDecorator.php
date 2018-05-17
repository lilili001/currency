<?php

namespace Modules\Currency\Repositories\Cache;

use Modules\Currency\Repositories\CurrencyRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCurrencyDecorator extends BaseCacheDecorator implements CurrencyRepository
{
    public function __construct(CurrencyRepository $currency)
    {
        parent::__construct();
        $this->entityName = 'currency.currencies';
        $this->repository = $currency;
    }
}
