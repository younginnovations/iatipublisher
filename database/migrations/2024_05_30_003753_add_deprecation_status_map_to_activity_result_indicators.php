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
        Schema::table('activity_result_indicators', function (Blueprint $table) {
            $defaultMap = [
                'measure'            => [],
                'ascending'          => [],
                'aggregation_status' => [],
                'title'              => [],
                'description'        => [],
                'document_link'      => [],
                'reference'          => [],
                'baseline'           => [],
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
        Schema::table('activity_result_indicators', function (Blueprint $table) {
            $table->dropColumn('deprecation_status_map');
        });
    }
};
