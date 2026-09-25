<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEvaluations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("personnel_id");
            $table->unsignedInteger("specialite_id");
            $table->unsignedInteger("semestre_id");
            $table->unsignedInteger("matiere_id");
            $table->string("codeEvaluation")->unique();
            $table->string("typeevaluation");
            $table->date("dateevaluation");
            $table->integer("duree");
            $table->timestamps();

            $table->foreign("personnel_id")->references("id")->on("personnels")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("specialite_id")->references("id")->on("specialites")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("semestre_id")->references("id")->on("semestres")->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('evaluations');
    }
}
