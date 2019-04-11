<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTableName('payment_logs'), function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_id')->unsigned();
            $table->json('response');
            $table->timestamps();

            $table->index(['payment_id']);

            $table->foreign('payment_id')->on($this->getTableName('payments'))->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTableName('payment_logs'));
    }

    protected function getTableName($table)
    {
        return config('payment.table_prefix') . $table;
    }
}
