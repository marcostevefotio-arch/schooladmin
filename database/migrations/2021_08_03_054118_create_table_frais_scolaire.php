<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFraisScolaire extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frais', function (Blueprint $table) {
            $table->id();
            $table->integer("inscription_id");
            $table->string("codeFrais")->unique();
            $table->integer("montant")->default(0);
            $table->date("dateVerssement");
            $table->text("motif")->nullable(true);
            $table->timestamps();

            $table->foreign("inscription_id")->references("id")->on("inscriptions")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frais');
    }
}
