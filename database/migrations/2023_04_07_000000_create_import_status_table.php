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
        Schema::create(DBTables::IMPORT_STATUS, function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->enum('status', Enums::IMPORT_STATUS);
            $table->enum('type', Enums::IMPORT_TYPE);
            $table->enum('template', Enums::IMPORT_TEMPLATE_TYPE);
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::table(
            DBTables::IMPORT_STATUS,
            function ($table) {
                $table->foreign('organization_id')->references('id')->on(DBTables::ORGANIZATIONS);
                $table->foreign('user_id')->references('id')->on(DBTables::USERS);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            DBTables::IMPORT_STATUS,
            function ($table) {
                $table->dropForeign('import_status_organization_id_foreign');
                $table->dropForeign('import_status_user_id_foreign');
            }
        );
        Schema::dropIfExists(DBTables::IMPORT_STATUS);
    }
};
