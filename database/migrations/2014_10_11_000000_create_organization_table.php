<?php

use App\Constants\DBTables;
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
        Schema::create(DBTables::ORGANIZATIONS, function (Blueprint $table) {
            $table->id();
            $table->string('publisher_id')->unique();
            $table->string('publisher_name')->unique();
            $table->string('publisher_type')->nullable();
            $table->string('identifier');
            $table->string('address')->nullable();
            $table->string('telephone')->nullable();
            $table->json('reporting_org')->nullable();
            $table->json('total_budget')->nullable();
            $table->json('recipient_org_budget')->nullable();
            $table->json('default_field_values')->nullable();
            $table->json('recipient_region_budget')->nullable();
            $table->json('recipient_country_budget')->nullable();
            $table->json('document_link')->nullable();
            $table->json('total_expenditure')->nullable();
            $table->json('name')->nullable();
            $table->string('country')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('organization_url')->nullable();
            $table->enum('status', Enums::ORGANIZATION_STATUS)->default('draft');
            $table->enum('iati_status', Enums::IATI_ORGANIZATION_STATUS)->default('pending');
            $table->boolean('is_published')->default(false);
            $table->string('registration_agency')->nullable();
            $table->string('registration_number')->nullable();
            $table->json('element_status')->nullable()->default('{"identifier":false, "name":false, "reporting_org":false, "total_budget":false, "total_expenditure":false, "recipient_org_budget":false, "recipient_country_budget":false, "recipient_region_budget":false, "document_link":false}');
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
        Schema::dropIfExists(DBTables::ORGANIZATIONS);
    }
};
