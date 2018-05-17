<?php

namespace Modules\Currency\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CurrencySymbol extends Model
{
    use Translatable;

    protected $table = 'currency__currencies_symbol';
    public $translatedAttributes = [];
    protected $fillable = ['currency','symbol'];
}
