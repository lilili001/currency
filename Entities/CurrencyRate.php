<?php

namespace Modules\Currency\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    use Translatable;

    protected $table = 'currency__currencies_rate';
    public $translatedAttributes = [];
    protected $fillable = ['currency_from','currency_to','rate','created_at','updated_at'];
}
