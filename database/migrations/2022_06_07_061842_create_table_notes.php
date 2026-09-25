<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("inscription_id");
            $table->bigInteger("matiere_id");
            $table->bigInteger("semestre_id");
            $table->string("codeNote")->unique();
            $table->string("typeevaluation");
            $table->double("moyenne");
            $table->string("year");
            $table->timestamps();

            $table->foreign("inscription_id")->references("id")->on("inscriptions")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("matiere_id")->references("id")->on("matieres")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("semestre_id")->references("id")->on("semestres")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
