<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('personnel_id')->nullable(true);
            $table->unsignedInteger('etudiant_id')->nullable(true);
            $table->unsignedInteger('enseignant_id')->nullable(true);
            $table->string("codeUser")->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('active')->default(1);
            $table->binary("avatar")->nullable(true);
            $table->string("avatarType")->nullable(true);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign("enseignant_id")->references("id")->on("enseignants")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("personnel_id")->references("id")->on("personnels")->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('users');
    }
}
