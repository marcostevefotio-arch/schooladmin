<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAntecedants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedants', function (Blueprint $table) {
            $table->id();
            $table->integer("etudiant_id");
            $table->string("codeAntecedants")->unique();
            $table->string("maladie");
            $table->string("dateconsultation")->nullable();
            $table->string("etat")->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('antecedants');
    }
}
