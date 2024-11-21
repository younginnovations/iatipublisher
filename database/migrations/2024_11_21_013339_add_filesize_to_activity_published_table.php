<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Create filesize with correct datatype.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(App\Constants\DBTables::ACTIVITY_PUBLISHED, function (Blueprint $table) {
            $table->float('filesize', 8, 2)->default(0)->before('created_at');
        });
    }

    /**
     * Drop filesize field.
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
