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
        Schema::create(DBTables::ORGANIZATIONS, function (Blueprint $table) {
            $table->id();
            $table->string('publisher_id')->unique();
            $table->enum('publisher_type', Enums::PUBLISHER_TYPE);
            $table->string('country');
            $table->enum('registration_agency', Enums::ORGANIZATION_REGISTRATION_AGENCY);
            $table->string('registration_number');
            $table->string('identifier');
            $table->enum('status', Enums::ORGANIZATION_STATUS);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTables::ORGANIZATIONS);
    }
};
