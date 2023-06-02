<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER table import_status DROP CONSTRAINT import_status_status_check;');
        DB::statement("ALTER table import_status ADD CONSTRAINT import_status_status_check CHECK
                        (((status)::text = ANY (ARRAY[
                            ('processing'::character varying)::text,
                            ('completed'::character varying)::text,
                            ('failed'::character varying)::text])));");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER table import_status DROP CONSTRAINT import_status_status_check;');
        DB::statement("ALTER table import_status ADD CONSTRAINT import_status_status_check CHECK
                        (((status)::text = ANY (ARRAY[
                                ('completed'::character varying)::text,
                                ('processing'::character varying)::text])));");
    }
};
