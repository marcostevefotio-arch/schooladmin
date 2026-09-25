<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVerssement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verssements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("inscription_id");
            $table->unsignedBigInteger("scolarite_id");
            $table->string("codeVerssement")->unique();
            $table->bigInteger("montantVerssement");
            $table->date("dateVerssement");
            $table->text("descriptionVerssement")->nullable(true);
            $table->timestamps();

            $table->foreign("inscription_id")->references("id")->on("inscriptions")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("scolarite_id")->references("id")->on("scolarites")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verssements');
    }
}
