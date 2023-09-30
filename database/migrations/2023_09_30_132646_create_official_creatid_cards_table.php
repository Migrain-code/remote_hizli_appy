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
        Schema::create('official_creatid_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number');
            $table->string('month');
            $table->string('year');
            $table->string('name_on_the_card');
            $table->boolean('is_default')->default(1);
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
        Schema::dropIfExists('official_creatid_cards');
    }
};
