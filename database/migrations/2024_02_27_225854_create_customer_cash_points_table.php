<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_cash_points', function (Blueprint $table) {
            $table->id();
            $table->integer('appointment_id');
            $table->integer('customer_id');
            $table->integer('business_id');
            $table->decimal('price', 10, 2);
            $table->timestamp('addition_date')->default(now());
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
        Schema::dropIfExists('customer_cash_points');
    }
};
