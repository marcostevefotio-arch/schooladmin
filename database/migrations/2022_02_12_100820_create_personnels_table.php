<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonnelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string("groupe_id");
            $table->string("code")->unique();
            $table->string("cni")->unique();
            $table->string("lastname")->default("Iconnu");
            $table->string("firstname")->nullable(true);
            $table->string("sexe")->default("Autre");
            $table->date("birthday")->nullable(true);
            $table->string("country")->default("Cameroun");
            $table->string("phone")->nullable(true);
            $table->string("adresse")->nullable(true);
            $table->timestamps();

            $table->foreign("groupe_id")->references("id")->on("groupes")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personnels');
    }
}
