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
    public function up(): void
    {
        Schema::create('organization_onboardings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('org_id');
            $table->boolean('completed_onboarding')->default(false);
            $table->json('steps_status');
            $table->boolean('dont_show_again')->default(false);

            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_onboardings');
    }
};
