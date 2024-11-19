<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Drop filesize.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(App\Constants\DBTables::ACTIVITY_PUBLISHED, function (Blueprint $table) {
            $table->dropColumn('filesize');
        });
    }
};
