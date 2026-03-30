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
        Schema::table('user_basic_extendeds', function (Blueprint $table) {
            $table->string('testimonial_left_shape_image')->nullable();
            $table->string('testimonial_right_shape_image')->nullable();
            $table->string('testimonial_bg_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_basic_extendeds', function (Blueprint $table) {
            $table->dropColumn('testimonial_left_shape_image');
            $table->dropColumn('testimonial_right_shape_image');
            $table->dropColumn('testimonial_bg_image');
        });
    }
};
