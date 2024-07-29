<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWaiterIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add the waiter_id column and set up the foreign key constraint
            $table->unsignedBigInteger('waiter_id')->nullable()->after('id');

            // Assuming the foreign key references the 'id' column on the 'users' table
            $table->foreign('waiter_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the foreign key and the column
            $table->dropForeign(['waiter_id']);
            $table->dropColumn('waiter_id');
        });
    }
}
