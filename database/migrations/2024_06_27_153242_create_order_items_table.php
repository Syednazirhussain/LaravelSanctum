<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->constrained('menu_items')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();

            $table->primary(['order_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
