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
            $table->string('hero_left_image')->nullable();
            $table->string('hero_right_image')->nullable();
            $table->string('hero_section_button_text1_url')->nullable();
            $table->string('hero_section_title')->nullable();
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
            $table->dropColumn('hero_left_image');
            $table->dropColumn('hero_right_image');
            $table->dropColumn('hero_section_button_text1_url');
            $table->dropColumn('hero_section_title');
        });
    }
};
