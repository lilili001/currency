<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyCurrencySymbolTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency__currencysymbol_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('currencysymbol_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['currencysymbol_id', 'locale']);
            $table->foreign('currencysymbol_id')->references('id')->on('currency__currencysymbols')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('currency__currencysymbol_translations', function (Blueprint $table) {
            $table->dropForeign(['currencysymbol_id']);
        });
        Schema::dropIfExists('currency__currencysymbol_translations');
    }
}
