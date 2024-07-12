<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('menu_item_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('img');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_item_categories');
    }
}
