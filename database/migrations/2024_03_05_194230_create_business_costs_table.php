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
        Schema::create('business_costs', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id');
            $table->integer('cost_category_id');
            $table->integer('personel_id');
            $table->integer('payment_type_id');
            $table->decimal('price', 10, 2);
            $table->date('operation_date')->default(now());
            $table->text('description')->nullable();
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
        Schema::dropIfExists('business_costs');
    }
};
