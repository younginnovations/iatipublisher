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
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->json('identifier');
            $table->json('other_identifier')->nullable();
            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->enum('status', ['draft', 'ready_to_publish', 'published'])->default('draft');
            $table->json('activity_date')->nullable();
            $table->json('contact_info')->nullable();
            $table->json('activity_scope')->nullable();
            $table->json('participating_organization')->nullable();
            $table->json('recipient_country')->nullable();
            $table->json('recipient_region')->nullable();
            $table->json('location')->nullable();
            $table->json('sector')->nullable();
            $table->json('country_budget_items')->nullable();
            $table->json('humanitarian_scope')->nullable();
            $table->json('policy_marker')->nullable();
            $table->json('collaboration_type')->nullable();
            $table->json('default_flow_type')->nullable();
            $table->json('default_finance_type')->nullable();
            $table->json('default_aid_type')->nullable();
            $table->json('default_tied_status')->nullable();
            $table->json('budget')->nullable();
            $table->json('planned_disbursement')->nullable();
            $table->json('capital_spend')->nullable();
            $table->json('document_link')->nullable();
            $table->json('related_activity')->nullable();
            $table->json('legacy_data')->nullable();
            $table->json('conditions')->nullable();
            $table->integer('org_id');
            $table->json('default_field_values')->nullable();
            $table->boolean('is_published')->default(0);
            $table->json('tag')->nullable();
            $table->timestamps();

            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
};
