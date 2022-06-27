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
        Schema::create(DBTables::DOCUMENTS, function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id');
            $table->string('filename');
            $table->string('extension');
            $table->float('size')->nullable();
            $table->timestamps();
        });

        Schema::table(
            DBTables::DOCUMENTS,
            function ($table) {
                $table->foreign('activity_id')->references('id')->on(DBTables::ACTIVITY);
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
            DBTables::DOCUMENTS,
            function ($table) {
                $table->dropForeign('documents_activity_id_foreign');
            }
        );
        Schema::dropIfExists(DBTables::DOCUMENTS);
    }
};
