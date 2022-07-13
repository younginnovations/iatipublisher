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
        Schema::create(DBTables::ORGANIZATION_PUBLISH, function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->integer('organization_id')->nullable();
            $table->boolean('published_to_registry');
            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on(DBTables::ORGANIZATIONS)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTables::ORGANIZATION_PUBLISH);
    }
};
