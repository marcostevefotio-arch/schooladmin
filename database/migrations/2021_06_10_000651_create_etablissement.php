<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtablissement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etablissements', function (Blueprint $table) {

            $table->id();
            $table->string("codeSchool")->unique();
            $table->string("scoolname")->unique();
            $table->string("schoolEmail")->nullable("true");
            $table->string("schoolPhone")->nullable("true");
            $table->string("schoolPobox")->nullable("true");
            $table->string("schoolAdresse")->nullable("true");
            $table->string("schoolSite")->nullable("true");
            $table->string("schoolLogo")->nullable("true");
            $table->string("schoolHead")->nullable("true");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etablissements');
    }
}
