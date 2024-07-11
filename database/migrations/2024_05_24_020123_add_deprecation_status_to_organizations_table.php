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
        Schema::table('organizations', function (Blueprint $table) {
            $defaultMap = [
                'organization_identifier'  => [],
                'name'                     => [],
                'reporting_org'            => [],
                'total_budget'             => [],
                'recipient_org_budget'     => [],
                'recipient_region_budget'  => [],
                'recipient_country_budget' => [],
                'total_expenditure'        => [],
                'document_link'            => [],
                'publisher_type'           => [],
                'identifier'               => [],
                'default_field_values'     => [],
            ];

            $table->json('deprecation_status_map')->nullable()->default(json_encode($defaultMap));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('deprecation_status_map');
        });
    }
};
