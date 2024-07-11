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
        Schema::table('activity_transactions', function (Blueprint $table) {
            $table->json('deprecation_status_map')->nullable()->default(json_encode([]));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_transactions', function (Blueprint $table) {
            $table->dropColumn('deprecation_status_map');
        });
    }
};
