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
        Schema::table('result_indicator_periods', function (Blueprint $table) {
            $table->boolean('migrated_from_aidstream')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('result_indicator_periods', function (Blueprint $table) {
            $table->dropColumn('migrated_from_aidstream');
        });
    }
};
