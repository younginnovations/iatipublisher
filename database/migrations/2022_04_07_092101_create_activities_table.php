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
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->json('iati_identifier');
            $table->json('other_identifier')->nullable();
            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->integer('activity_status')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->json('activity_date')->nullable();
            $table->json('contact_info')->nullable();
            $table->integer('activity_scope')->nullable();
            $table->json('participating_org')->nullable();
            $table->json('recipient_country')->nullable();
            $table->json('recipient_region')->nullable();
            $table->json('location')->nullable();
            $table->json('sector')->nullable();
            $table->json('country_budget_items')->nullable();
            $table->json('humanitarian_scope')->nullable();
            $table->json('policy_marker')->nullable();
            $table->integer('collaboration_type')->nullable();
            $table->integer('default_flow_type')->nullable();
            $table->integer('default_finance_type')->nullable();
            $table->json('default_aid_type')->nullable();
            $table->integer('default_tied_status')->nullable();
            $table->json('budget')->nullable();
            $table->json('planned_disbursement')->nullable();
            $table->float('capital_spend')->nullable();
            $table->json('document_link')->nullable();
            $table->json('related_activity')->nullable();
            $table->json('legacy_data')->nullable();
            $table->json('conditions')->nullable();
            $table->integer('org_id');
            $table->json('default_field_values')->nullable();
            $table->boolean('linked_to_iati')->default(0);
            $table->json('tag')->nullable();
            $table->json('element_status')->nullable()->default('{"iati_identifier":false, "title":false, "description":false, "activity_status":false, "activity_date":false, "activity_scope":false, "recipient_country":false, "recipient_region":false, "collaboration_type":false, "default_flow_type":false, "default_finance_type":false, "default_aid_type":false, "default_tied_status":false, "capital_spend":false, "related_activity":false, "conditions":false, "sector":false, "humanitarian_scope":false, "legacy_data":false, "tag":false, "policy_marker":false, "other_identifier":false, "country_budget_items":false, "budget":false, "participating_org":false, "document_link":false, "contact_info":false, "location":false, "planned_disbursement":false, "transactions":false, "result":false}');
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('updated_by');

            $table->foreign('created_by')->references('id')->on(DBTables::USERS)->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on(DBTables::USERS)->onDelete('cascade');
            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
