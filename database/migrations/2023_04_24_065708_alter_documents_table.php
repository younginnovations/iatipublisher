<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'organization_id')) {
                $table->integer('organization_id')->nullable();
            }
            if (Schema::hasColumn('documents', 'activity_id')) {
                DB::statement('ALTER table documents ALTER activity_id drop not null;');
            }
            if (Schema::hasColumn('documents', 'filename')) {
                DB::statement('ALTER table documents ALTER filename drop not null;');
            }
            if (Schema::hasColumn('documents', 'extension')) {
                DB::statement('ALTER table documents ALTER extension drop not null;');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents', 'organization_id')) {
                $table->dropColumn('organization_id');
            }
            if (Schema::hasColumn('documents', 'activity_id')) {
                DB::statement('ALTER table documents ALTER activity_id drop not null;');
            }
            if (Schema::hasColumn('documents', 'filename')) {
                DB::table('documents')->whereNull('filename')->update(['filename' => '']);
                DB::statement('ALTER table documents ALTER filename set not null;');
            }
            if (Schema::hasColumn('documents', 'extension')) {
                DB::table('documents')->whereNull('extension')->update(['extension' => '']);
                DB::statement('ALTER table documents ALTER extension set not null;');
            }
        });
    }
};
