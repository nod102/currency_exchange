<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_amounts', function (Blueprint $table) {
            $table->id();
            $table->integer('currency_id');
            $table->integer('currency_exchange_id');
            $table->string('currency_name');
            $table->string('currency_exchange_name');
            $table->float('currency_exchange_value', 8, 2);
            $table->float('amount', 8, 2);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_amounts');
    }
}
