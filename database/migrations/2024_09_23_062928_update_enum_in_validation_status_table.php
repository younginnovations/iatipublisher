<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateEnumInValidationStatusTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE validation_status DROP CONSTRAINT validation_status_status_check');

        DB::statement("ALTER TABLE validation_status ADD CONSTRAINT validation_status_status_check CHECK (status IN ('processing', 'completed', 'failed', 'max_merge_size_exception'))");
    }

    /**
     * @return void
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE validation_status DROP CONSTRAINT validation_status_status_check');

        DB::statement("ALTER TABLE validation_status ADD CONSTRAINT validation_status_status_check CHECK (status IN ('processing', 'completed', 'failed'))"); // Replace with your previous values
    }
}
