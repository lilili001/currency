<?php

namespace Modules\Currency\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{

    protected $table = 'currency__currencies_rate';

    protected $fillable = ['currency_from','currency_to','rate', 'symbol', 'created_at','updated_at'];
}
