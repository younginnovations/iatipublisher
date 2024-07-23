<?php

declare(strict_types=1);

use App\Constants\DBTables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
 * Change source: https://github.com/younginnovations/iatipublisher/issues/1491
 */
return new class extends Migration {
    /**
     * Making email field case-insensitive by:
     * 1. Creating citext extension. Citext datatype makes string values case-insensitive on db level.
     * 2. Change email field type to citext.
     * 3. Refresh unique constraint in email field.
     *
     * @return void
     */
    public function up(): void
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS citext;');

        DB::statement('ALTER TABLE ' . DBTables::USERS . ' ALTER COLUMN email TYPE citext USING email::citext;');

        $uniqueConstraintExists = DB::select(
            "
            SELECT constraint_name
            FROM information_schema.table_constraints
            WHERE table_name = '" . DBTables::USERS . "'
            AND constraint_type = 'UNIQUE'
            AND constraint_name = 'users_email_unique'"
        );

        if (empty($uniqueConstraintExists)) {
            Schema::table(DBTables::USERS, function (Blueprint $table) {
                $table->unique('email');
            });
        }
    }

    /**
     * Reverse the migration.
     * Basically
     * 1. Drop unique constraint.
     * 2. Change email field type to varchar.
     * 3. Add unique constraint again.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(DBTables::USERS, function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
        });

        DB::statement('ALTER TABLE ' . DBTables::USERS . ' ALTER COLUMN email TYPE varchar USING email::varchar;');

        Schema::table(DBTables::USERS, function (Blueprint $table) {
            $table->unique('email');
        });
    }
};
