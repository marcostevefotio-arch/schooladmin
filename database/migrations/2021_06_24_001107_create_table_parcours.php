<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableParcours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcours', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("dossieretudiant_id");
            $table->string("codeParcours")->unique();
            $table->string("admissiondiploma");
            $table->string("option");
            $table->string("schoolyear");
            $table->string("diplomacountry");
            $table->string("schoolattended");
            $table->timestamps();

            $table->foreign("dossieretudiant_id")->references("id")->on("dossieretudiants")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcours');
    }
}
