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
        Schema::table('customer_notification_mobiles', function (Blueprint $table) {
            $table->boolean('type')->default(0)->after('status')->comment('1 => cashpoint');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_notification_mobiles', function (Blueprint $table) {
            //
        });
    }
};
