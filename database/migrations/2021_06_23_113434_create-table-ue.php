<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ues', function (Blueprint $table) {
            $table->id();
            $table->integer("typeue_id");
            $table->integer("specialite_id");
            $table->integer("semestre_id");
            $table->string('codeUE')->unique();
            $table->string('libelleUE');
            $table->integer('cm');
            $table->integer('td');
            $table->integer('tp');
            $table->integer('tpe');
            $table->integer('total');
            $table->integer('credit');
            $table->timestamps();

            $table->foreign("typeue_id")->references("id")->on("typeues")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("specialite_id")->references("id")->on("specialites")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("semestre_id")->references("id")->on("semestres")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ues');
    }
}
