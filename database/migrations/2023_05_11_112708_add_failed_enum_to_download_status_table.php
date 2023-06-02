<?php

use App\Constants\Enums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('download_status', function (Blueprint $table) {
            DB::statement('ALTER TABLE download_status DROP CONSTRAINT download_status_status_check');
            $types = array_merge(Enums::IMPORT_STATUS, ['failed']);
            $status = implode(', ', array_map(function ($value) {
                return sprintf("'%s'::character varying", $value);
            }, $types));

            DB::statement("ALTER TABLE download_status ADD CONSTRAINT download_status_status_check CHECK (status::text = ANY (ARRAY[$status]::text[]))");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('download_status', function (Blueprint $table) {
            DB::statement('ALTER TABLE download_status DROP CONSTRAINT download_status_status_check');

            $types = Enums::IMPORT_STATUS;
            $status = implode(', ', array_map(function ($value) {
                return sprintf("'%s'::character varying", $value);
            }, $types));

            DB::statement("ALTER TABLE download_status ADD CONSTRAINT download_status_status_check CHECK (status::text = ANY (ARRAY[$status]::text[]))");
        });
    }
};
