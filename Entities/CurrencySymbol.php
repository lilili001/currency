<?php

namespace Modules\Currency\Entities;

use Illuminate\Database\Eloquent\Model;

class CurrencySymbol extends Model
{
    protected $table = 'currency__currencies_symbol';
    protected $fillable = ['currency','symbol'];
    public $timestamps = false;
}
