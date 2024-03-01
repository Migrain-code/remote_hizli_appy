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
        Schema::table('business_promossions', function (Blueprint $table) {
            $table->dropColumn('payment_type');
            $table->integer('cash')->default(0);
            $table->integer('credit_cart')->default(0);
            $table->integer('eft')->default(0);
            $table->integer('use_limit')->default(0);
            $table->integer('birthday_discount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_promossions', function (Blueprint $table) {
            //
        });
    }
};
