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
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn('owner');
            $table->dropColumn('owner_email');
            $table->dropColumn('email');
            $table->dropColumn('password');
            $table->dropColumn('long');
            $table->dropColumn('verification_code');
            $table->dropColumn('password_status');
            $table->dropColumn('verify_phone');
            $table->dropColumn('slider');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
