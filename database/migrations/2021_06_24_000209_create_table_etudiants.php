<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEtudiants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->integer("parent_id")->nullable(true);
            $table->integer("groupe_id")->default(2);
            $table->string("codeEtudiant")->unique();
            $table->string("lastname");
            $table->string("firstname");
            $table->string("sexe");
            $table->date("birthday");
            $table->string("birthplace");
            $table->string("nationality")->default("Camerounaise");
            $table->string("region");
            $table->string("phonenumber");
            $table->string("language")->default("Francais");
            $table->string("sport")->nullable(true);
            $table->string("leisure")->nullable(true);
            $table->string("email")->unique();
            $table->string('password')->default(\Illuminate\Support\Facades\Hash::make("superadmin"));
            $table->binary("avatar")->nullable(true);
            $table->string("avatarType")->nullable(true);
            $table->boolean("active")->default(false);
            $table->timestamps();

            $table->foreign("parent_id")->references("id")->on("parents")->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('etudiants');
    }
}
