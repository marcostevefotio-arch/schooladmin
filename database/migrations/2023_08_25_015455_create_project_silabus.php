<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectSilabus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syllabus', function (Blueprint $table) {
            $table->id();
            $table->integer("matiere_id");
            $table->string("codeSyllabus")->unique();
            $table->string("titleSyllabus");
            $table->text("descriptionSyllabus")->nullable(true);
            $table->boolean("statusSyllabus")->default(false);
            $table->timestamps();

            $table->foreign("matiere_id")->references("id")->on("matieres")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syllabus');
    }
}
