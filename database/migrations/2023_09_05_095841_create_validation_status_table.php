<?php

declare(strict_types=1);

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
        Schema::create(DBTables::VALIDATION_STATUS, function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('activity_id');
            $table->enum('status', Enums::IMPORT_STATUS);
            $table->json('response')->nullable();
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
        Schema::dropIfExists(DBTables::VALIDATION_STATUS);
    }
};
