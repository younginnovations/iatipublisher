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
        Schema::create(DBTables::USERS, function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->integer('organization_id')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table(
            DBTables::USERS,
            function ($table) {
                $table->foreign('organization_id')->references('id')->on(DBTables::ORGANIZATIONS);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            DBTables::USERS,
            function ($table) {
                $table->dropForeign('users_organization_id_foreign');
            }
        );
        Schema::dropIfExists(DBTables::USERS);
    }
};
