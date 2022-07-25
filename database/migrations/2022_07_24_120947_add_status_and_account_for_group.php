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
        Schema::table('groups', function($table)
        {
            $table->tinyInteger('status')->default(0);
            $table->foreignId('account_id')->unsigned()->constrained('trainer_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function($table)
        {
            $table->dropColumn('status');
            $table->dropColumn('account_id');
        });
    }
};
