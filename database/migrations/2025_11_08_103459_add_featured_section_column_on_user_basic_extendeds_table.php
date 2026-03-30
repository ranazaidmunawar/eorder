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
            $table->string('featured_section_title')->nullable();
            $table->string('featured_right_shape_image')->nullable();
            $table->string('featured_left_shape_image')->nullable();
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
            $table->dropColumn('featured_section_title');
            $table->dropColumn('featured_right_shape_image');
            $table->dropColumn('featured_left_shape_image');
        });
    }
};
