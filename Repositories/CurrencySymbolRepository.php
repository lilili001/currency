<?php

namespace Modules\Currency\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CurrencySymbolRepository extends BaseRepository
{
    public function all();
}
