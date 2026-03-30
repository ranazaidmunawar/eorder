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
            $table->string('top_header_support_text')->nullable();
            $table->string('top_header_support_email')->nullable();
            $table->string('top_header_middle_text')->nullable();
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
            $table->dropColumn('top_header_support_text');
            $table->dropColumn('top_header_support_email');
            $table->dropColumn('top_header_middle_text');
        });
    }
};
