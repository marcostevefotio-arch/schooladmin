<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("menu_id")->nullable(true);
            $table->string("code_menu")->unique();
            $table->string("libelle_menu")->unique();
            $table->text("description_menu")->nullable(true);
            $table->string("icon_menu");
            $table->string("slug")->unique();
            $table->boolean("is_link")->default(true);
            $table->timestamps();

            $table->foreign("menu_id")->references("id")->on("menus")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
