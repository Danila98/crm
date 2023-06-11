<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('work_time');
            $table->foreignId('city_id')->unsigned()->after('description')->constrained('cities');
            $table->string('street')->nullable()->after('city_id');
            $table->integer('house')->nullable()->after('street');
            $table->string('building')->nullable()->after('house');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->string('address');
            $table->string('work_time');
            $table->dropForeign('city_id');
            $table->dropColumn('street');
            $table->dropColumn('house');
            $table->dropColumn('building');
        });
    }
};
