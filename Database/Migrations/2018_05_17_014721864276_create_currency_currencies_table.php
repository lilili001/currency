<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency__currencies_rate', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            //从接口查询返回
            $table->string('currency_from');//usd
            $table->string('currency_to');
            $table->decimal('rate');
            $table->timestamps();
        });

        Schema::create('currency__currencies_symbol', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('currency');
            $table->string('symbol');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency__currencies_rate');
        Schema::dropIfExists('currency__currencies_symbol');
    }
}
