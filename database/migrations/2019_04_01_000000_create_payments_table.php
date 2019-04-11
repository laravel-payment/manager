<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTableName('payments'), function (Blueprint $table) {
            $table->increments('id');
            $table->nullableMorphs('user');
            $table->string('provider');
            $table->string('provider_order_id')->nullable();
            $table->string('provider_status')->nullable();
            $table->smallInteger('currency');
            $table->decimal('amount', 10, 2);
            $table->tinyInteger('status');
            $table->timestamps();

            $table->unique(['provider', 'provider_order_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTableName('payments'));
    }

    protected function getTableName($table)
    {
        return config('payment.table_prefix') . $table;
    }
}
