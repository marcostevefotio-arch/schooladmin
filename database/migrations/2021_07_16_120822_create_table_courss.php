<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCourss extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->integer("specialite_id");
            $table->integer("matiere_id");
            $table->integer("enseignant_id");
            $table->string("codeCours")->unique();
            $table->string("intituleCours")->default("");
            $table->dateTime("debutCours");
            $table->double("dureeCours")->default(1);
            $table->boolean("termine")->default(false);
            $table->timestamps();

            $table->foreign("specialite_id")->references("id")->on("specialites")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("matiere_id")->references("id")->on("matieres")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("enseignant_id")->references("id")->on("enseignants")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cours');
    }
}
