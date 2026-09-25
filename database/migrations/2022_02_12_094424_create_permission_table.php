<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("menu_id")->unsigned();
            $table->string("codePermissions")->unique();
            $table->string("code_permission")->unique();
            $table->string("titre_permission");
            $table->string("action")->default("");
            $table->string("icon")->default("");
            $table->timestamps();

            $table->foreign("menu_id")->references("id")->on("modules")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
