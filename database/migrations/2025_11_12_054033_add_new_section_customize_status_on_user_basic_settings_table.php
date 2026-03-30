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
        Schema::table('user_basic_settings', function (Blueprint $table) {
            $table->tinyInteger('banner_section')->default(1);
            $table->tinyInteger('featured_category_section')->default(1);
            $table->tinyInteger('affordable_section')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_basic_settings', function (Blueprint $table) {
            $table->dropColumn('banner_section');
            $table->dropColumn('featured_category_section');
            $table->dropColumn('affordable_section');
        });
    }
};
