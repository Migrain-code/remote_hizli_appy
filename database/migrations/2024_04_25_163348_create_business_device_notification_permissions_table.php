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
        Schema::create('business_device_notification_permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id');
            $table->boolean('is_me')->default(0);
            $table->boolean('is_all')->default(0);
            $table->boolean('is_customer')->default(0);
            $table->boolean('is_personel')->default(0);
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
        Schema::dropIfExists('business_device_notification_permissions');
    }
};
