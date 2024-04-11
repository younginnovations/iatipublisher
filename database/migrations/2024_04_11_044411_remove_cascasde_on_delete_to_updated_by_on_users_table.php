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
        Schema::table(DBTables::USERS, static function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);

            $table->foreign('created_by')->references('id')->on(DBTables::USERS)->onDelete('set null');
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
        Schema::table(DBTables::USERS, static function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);

            $table->foreign('created_by')->references('id')->on(DBTables::USERS)->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on(DBTables::USERS)->onDelete('cascade');
        });
    }
};
