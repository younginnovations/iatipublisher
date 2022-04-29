<?php

use App\Constants\DBTables;
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
        Schema::create(DBTables::SETTINGS, function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->json('publishing_info')->nullable();
            $table->json('default_values')->nullable();
            $table->json('activity_default_values')->nullable();
            $table->timestamps();
        });

        Schema::table(
            DBTables::SETTINGS,
            function ($table) {
                $table->foreign('organization_id')->references('id')->on(DBTables::ORGANIZATIONS);
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
            DBTables::SETTINGS,
            function ($table) {
                $table->dropForeign('settings_organization_id_foreign');
            }
        );
        Schema::dropIfExists(DBTables::SETTINGS);
    }
};
