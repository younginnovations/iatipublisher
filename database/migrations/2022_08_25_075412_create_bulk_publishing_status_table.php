<?php

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
        Schema::create('bulk_publishing_status', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->integer('activity_id');
            $table->string('activity_title');
            $table->enum('status', Enums::BULK_PUBLISHING_STATUS)->default('processing');
            $table->string('job_batch_uuid');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
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
        Schema::dropIfExists('bulk_publishing_status');
    }
};
