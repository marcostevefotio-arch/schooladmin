<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableResultats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultats', function (Blueprint $table) {
            $table->id();
            $table->integer("inscription_id");
            $table->integer("level_id");
            $table->integer("anneeacademique_id");
            $table->double("semestre1")->default(false);
            $table->double("semestre2")->default(false);
            $table->boolean("redouble")->default(false);
            $table->timestamps();

            $table->foreign("inscription_id")->references("id")->on("inscriptions")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("level_id")->references("id")->on("levels")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("anneeacademique_id")->references("id")->on("anneeacademiques")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultats');
    }
}
