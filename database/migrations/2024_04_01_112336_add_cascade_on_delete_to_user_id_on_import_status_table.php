<?php

declare(strict_types=1);

use App\Constants\DBTables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Add cascade on delete constraint to foreign key: user_id .
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(DBTables::IMPORT_STATUS, function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->foreign('user_id')->references('id')->on(DBTables::USERS)->onDelete('cascade');
        });
    }

    /**
     * Removes cascade on delete constraint to foreign key: user_id .
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(DBTables::IMPORT_STATUS, function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->foreign('user_id')->references('id')->on(DBTables::USERS);
        });
    }
};
