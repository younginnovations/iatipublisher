<?php

declare(strict_types=1);

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
        Schema::table('activities', function (Blueprint $table) {
            $defaultMap = [
                'iati_identifier'      => [],
                'other_identifier'     => [],
                'title'                => [],
                'description'          => [],
                'activity_status'      => [],
                'activity_date'        => [],
                'contact_info'         => [],
                'activity_scope'       => [],
                'participating_org'    => [],
                'recipient_country'    => [],
                'recipient_region'     => [],
                'location'             => [],
                'sector'               => [],
                'country_budget_items' => [],
                'humanitarian_scope'   => [],
                'policy_marker'        => [],
                'collaboration_type'   => [],
                'default_flow_type'    => [],
                'default_finance_type' => [],
                'default_aid_type'     => [],
                'default_tied_status'  => [],
                'budget'               => [],
                'planned_disbursement' => [],
                'capital_spend'        => [],
                'document_link'        => [],
                'related_activity'     => [],
                'legacy_data'          => [],
                'conditions'           => [],
                'tag'                  => [],
                'reporting_org'        => [],
            ];

            $table->json('deprecation_status_map')->nullable()->default(json_encode($defaultMap));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('deprecation_status_map');
        });
    }
};
