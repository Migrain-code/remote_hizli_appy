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
        Schema::create('appointment_receivables', function (Blueprint $table) {
            $table->id();
            $table->integer('appointment_id')->nullable();
            $table->integer('business_id');
            $table->integer('customer_id');
            $table->date('payment_date')->default(now()->addDays(7));
            $table->decimal('price', 10, 2);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('appointment_receivables');
    }
};
