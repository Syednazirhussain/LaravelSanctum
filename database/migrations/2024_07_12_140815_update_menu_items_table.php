<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMenuItemsTable extends Migration
{
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->unsignedBigInteger('item_category_id')->after('id');
            $table->string('img')->after('item_category_id');
            $table->foreign('item_category_id')->references('id')->on('menu_item_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropForeign(['item_category_id']);
            $table->dropColumn('item_category_id');
            $table->dropColumn('img');
        });
    }
}
