<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableNationalite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Nationalites', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("pays_id");
            $table->string('codeNationalite');
            $table->string('titreNationalité');
            $table->timestamps();

            $table->foreign("pays_id")->references("id")->on("pays")->onDelete("cascade")->onUpdate("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Nationalites');
    }
}
