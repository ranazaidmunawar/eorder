<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affordable_deals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('language_id');
            $table->bigInteger('user_id');
            $table->string('section_title')->nullable();
            $table->text('section_items')->nullable();
            $table->string('left_shape_image')->nullable();
            $table->string('right_shape_image')->nullable();
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
        Schema::dropIfExists('affordable_deals');
    }
};
