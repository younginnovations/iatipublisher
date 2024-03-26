<?php

declare(strict_types=1);

use App\Constants\DBTables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Adds cascade on delete constraint to foreign key: user_id .
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(DBTables::IMPORT_STATUS, function (Blueprint $table) {
            $table->dropForeign(['organization_id']);

            $table->foreign('organization_id')->references('id')->on(DBTables::ORGANIZATIONS)->onDelete('cascade');
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
            $table->dropForeign(['organization_id']);

            $table->foreign('organization_id')->references('id')->on(DBTables::ORGANIZATIONS);
        });
    }
};
