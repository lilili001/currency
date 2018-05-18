<?php

namespace Modules\Currency\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CurrencyCode extends Model
{
    protected $table = 'currency_code';
    protected $guarded = [];
    public $timestamps = false;
}
