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
        DB::statement('ALTER table activities DROP CONSTRAINT activities_upload_medium_check;');
        DB::statement("ALTER table activities ADD CONSTRAINT activities_upload_medium_check CHECK
                        (((upload_medium)::text = ANY (ARRAY[
                            ('xls'::character varying)::text,
                            ('csv'::character varying)::text,
                            ('xml'::character varying)::text,
                            ('manual'::character varying)::text])));");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER table activities DROP CONSTRAINT activities_upload_medium_check;');
        DB::statement("ALTER table activities ADD CONSTRAINT activities_upload_medium_check CHECK
                        (((upload_medium)::text = ANY (ARRAY[
                                ('csv'::character varying)::text,
                                ('xml'::character varying)::text,
                                ('manual'::character varying)::text])));");
    }
};
