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
        Schema::table('download_status', function (Blueprint $table) {
            if (!Schema::hasColumn('download_status', 'url')) {
                $table->text('url')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('download_status', function (Blueprint $table) {
            if (Schema::hasColumn('download_status', 'url')) {
                $table->dropColumn('url');
            }
        });
    }
};
