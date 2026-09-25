<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("anneeacademique_id");
            $table->bigInteger("dossieretudiant_id");
            $table->bigInteger("level_id");
            $table->string("codeInscription")->unique();
            $table->dateTime("dateInscription")->nullable(false);
            $table->text("divers")->nullable(true);
            $table->string("scanfile")->nullable(true);
            $table->timestamps();

            $table->foreign("anneeacademique_id")->references("id")->on("anneeacademiques")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("dossieretudiant_id")->references("id")->on("dossieretudiants")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("level_id")->references("id")->on("levels")->onDelete("cascade")->onUpdate("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inscriptions');
    }
}
