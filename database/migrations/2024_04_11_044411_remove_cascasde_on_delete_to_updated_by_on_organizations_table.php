<?php

declare(strict_types=1);

use App\Constants\DBTables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(DBTables::ORGANIZATIONS, static function (Blueprint $table) {
            $table->dropForeign(['updated_by']);

            $table->foreign('updated_by')->references('id')->on(DBTables::USERS)->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(DBTables::ORGANIZATIONS, static function (Blueprint $table) {
            $table->dropForeign(['updated_by']);

            $table->foreign('updated_by')->references('id')->on(DBTables::USERS)->onDelete('cascade');
        });
    }
};
