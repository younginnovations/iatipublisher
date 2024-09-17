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
    public function up(): void
    {
        Schema::table(App\Constants\DBTables::ACTIVITY_PUBLISHED, function (Blueprint $table) {
            $table->string('filesize')->default('0')->before('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(App\Constants\DBTables::ACTIVITY_PUBLISHED, function (Blueprint $table) {
            $table->dropColumn('filesize');
        });
    }
};
