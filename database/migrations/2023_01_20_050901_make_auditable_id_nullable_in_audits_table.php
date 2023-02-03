<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER table audits ALTER auditable_type drop not null;');
        DB::statement('ALTER table audits ALTER auditable_id drop not null;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER table audits ALTER auditable_type set not null;');
        DB::statement('ALTER table audits ALTER auditable_id set not null;');
    }
};
