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
            $table->string('left_top_shape')->nullable();
            $table->string('left_bottom_shape')->nullable();
            $table->string('right_top_shape')->nullable();
            $table->string('right_bottom_shape')->nullable();
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
            $table->dropColumn('left_top_shape');
            $table->dropColumn('left_bottom_shape');
            $table->dropColumn('right_top_shape');
            $table->dropColumn('right_bottom_shape');
        });
    }
};
