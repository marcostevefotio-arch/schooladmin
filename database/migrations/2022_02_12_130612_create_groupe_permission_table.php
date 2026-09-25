<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupe_permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("groupe_id");
            $table->unsignedInteger("permission_id");
            $table->timestamps();

            $table->foreign("groupe_id")->references("id")->on("groupes")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("permission_id")->references("id")->on("permissions")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupe_permission');
    }
}
