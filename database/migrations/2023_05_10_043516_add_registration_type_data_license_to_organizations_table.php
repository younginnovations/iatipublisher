<?php

use App\Constants\DBTables;
use App\Constants\Enums;
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
        Schema::table(DBTables::ORGANIZATIONS, function (Blueprint $table) {
            $table->enum('registration_type', array_keys(Enums::ORGANIZATION_REGISTRATION_METHOD))->nullable();
            $table->string('data_license')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTables::ORGANIZATIONS, function (Blueprint $table) {
            $table->dropColumn('registration_type');
            $table->dropColumn('data_license');
        });
    }
};
