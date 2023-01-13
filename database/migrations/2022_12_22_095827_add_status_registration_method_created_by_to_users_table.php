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
        Schema::table(DBTables::USERS, function (Blueprint $table) {
            $table->boolean('status')->default(true);
            $table->enum('registration_method', Enums::REGISTRATION_METHOD)->default('existing_org');
            $table->enum('language_preference', Enums::LANGUAGE_PREFERENCE)->default('en');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on(DBTables::USERS)->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on(DBTables::USERS)->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTables::USERS, function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('registration_method');
            $table->dropColumn('language_preference');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropSoftDeletes();
        });
    }
};
