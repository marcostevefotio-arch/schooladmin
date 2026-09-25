<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableScolarite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scolarites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("compte_id");
            $table->unsignedBigInteger("specialite_id");
            $table->unsignedBigInteger("anneeacademique_id");
            $table->string("codeScolarite")->unique();
            $table->bigInteger("montantScolarite");
            $table->text("descriptionScolarite")->nullable(true);
            $table->timestamps();

            $table->foreign("compte_id")->references("id")->on("comptes")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("specialite_id")->references("id")->on("specialites")->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('scolarites');
    }
}
