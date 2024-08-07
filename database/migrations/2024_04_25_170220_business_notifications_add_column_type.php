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
        Schema::table('business_notifications', function (Blueprint $table) {
            $table->boolean('type')->default(0)->after('business_id')->comment('0 => normal, 1 parapuan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_notifications', function (Blueprint $table) {
            //
        });
    }
};
