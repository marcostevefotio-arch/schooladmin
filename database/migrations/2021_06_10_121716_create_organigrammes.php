<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganigrammes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organigrammes', function (Blueprint $table) {
            $table->id();
            $table->string("codeOrganisation")->unique();
            $table->unsignedInteger("organisation_id")->nullable(true);
            $table->unsignedInteger("user_id")->nullable(true);
            $table->string("organisationTitle");
            $table->string("organisationDescription")->nullable();
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("organisation_id")->references("id")->on("organisations")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organigrammes');
    }
}
