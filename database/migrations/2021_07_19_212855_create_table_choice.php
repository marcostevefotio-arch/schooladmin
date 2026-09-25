<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableChoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('choices', function (Blueprint $table) {
            $table->id();
            $table->integer("specialite_id");
            $table->integer("inscription_id");
            $table->integer("etat")->default(0);
            $table->timestamps();

            $table->foreign("specialite_id")->references("id")->on("specialites")->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('choices');
    }
}
