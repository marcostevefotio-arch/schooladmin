<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSpecialite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialites', function (Blueprint $table) {
            $table->id();
            $table->integer("filiere_id");
            $table->string("codeSpecialite")->unique();
            $table->string("libelleSpecialite");
            $table->string("descriptionSpecialite")->nullable(true);
            $table->timestamps();

            $table->foreign("filiere_id")->references("id")->on("filieres")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialites');
    }
}
