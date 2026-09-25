<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableParents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string("codeParent")->unique();
            $table->string("fathername")->nullable(true);
            $table->string("fatherprofession")->nullable(true);
            $table->string("fathercontact")->nullable(true);
            $table->string("mothername")->nullable(true);
            $table->string("motherprofession")->nullable(true);
            $table->string("mothercontact")->nullable(true);
            $table->string("emergencyname");
            $table->string("emergencycontact");
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
        Schema::dropIfExists('parents');
    }
}
