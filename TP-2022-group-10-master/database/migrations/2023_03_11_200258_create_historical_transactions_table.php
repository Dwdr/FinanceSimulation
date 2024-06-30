<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricalTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historical_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->string("symbol");
            $table->integer("quantity");
            $table->float("order_value");
            $table->float("total_order_value");
            $table->float("total_value");
            $table->text("changes");
            $table->date("transaction_date");
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
        Schema::dropIfExists('historical_transactions');
    }
}
