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
            $table->enum('org_status', Enums::ORGANIZATION_SYSTEM_STATUS)->default('active');
            $table->integer('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on(DBTables::USERS)->onDelete('cascade');
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
            $table->dropColumn('org_status');
            $table->dropColumn('updated_by');
        });
    }
};
