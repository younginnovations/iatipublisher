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
        Schema::create('activity_result_indicators', function (Blueprint $table) {
            $table->id();
            $table->integer('result_id')->nullable();
            $table->foreign('result_id')->references('id')->on('activity_results')->onDelete('cascade');
            $table->json('indicator');
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
        Schema::dropIfExists('activity_result_indicators');
    }
};
