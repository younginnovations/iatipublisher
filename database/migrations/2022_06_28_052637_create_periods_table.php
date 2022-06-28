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
        Schema::create('result_indicator_periods', function (Blueprint $table) {
            $table->id();
            $table->integer('indicator_id')->nullable();
            $table->foreign('indicator_id')->references('id')->on('activity_result_indicators')->onDelete('cascade');
            $table->json('period');
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
        Schema::dropIfExists('result_indicator_periods');
    }
};
