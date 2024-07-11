<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER table activities ALTER created_by drop not null;');
        DB::statement('ALTER table activities ALTER updated_by drop not null;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER table activities ALTER created_by set not null;');
        DB::statement('ALTER table activities ALTER updated_by set not null;');
    }
};
