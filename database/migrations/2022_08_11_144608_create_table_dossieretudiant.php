<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDossieretudiant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dossieretudiants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('anneeacademique_id');
            $table->bigInteger("cycle_id");
            $table->bigInteger('etudiant_id');
            $table->string("codeDossier")->unique();
            $table->string("numeroDossier")->unique();
            $table->string('matriculeDossier')->unique();
            $table->timestamps();

            $table->foreign("anneeacademique_id")->references("id")->on("anneeacademiques")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("cycle_id")->references("id")->on("cycles")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("etudiant_id")->references("id")->on("etudiants")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dossieretudiants');
    }
}
