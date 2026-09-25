<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEnseignants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->integer("personnel_id")->nullable(true);
            $table->string("codeEnseignant")->unique();
            $table->string("lastname");
            $table->string("firstname");
            $table->string("sexe");
            $table->string("nationality")->default("Camerounaise");
            $table->string("phonenumber");
            $table->string("diplome")->nullable(true);
            $table->string("grade")->nullable(true);
            $table->string("specialite");
            $table->string("email")->unique();
//            $table->binary("photo")->nullable(true);
//            $table->string("photoType")->nullable(true);
            $table->timestamps();

            $table->foreign("personnel_id")->references("id")->on("personnels")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enseignants');
    }
}
