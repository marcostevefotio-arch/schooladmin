<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEnseignantMatiere extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enseignant_matieres', function (Blueprint $table) {
            $table->id();
            $table->integer("enseignant_id");
            $table->integer("matiere_id");
            $table->string("codeEM")->unique();
            $table->integer("niveau");
            $table->boolean("etat")->default(true);
            $table->timestamps();

            $table->foreign("enseignant_id")->references("id")->on("enseignants")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("matiere_id")->references("id")->on("matieres")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enseignant_matieres');
    }
}
