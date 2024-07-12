<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRolesTable extends Migration
{
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            // $table->renameColumn('role_name', 'name');
            $table->string('code')->after('name');
        });
    }

    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            // $table->renameColumn('name', 'role_name');
            $table->dropColumn('code');
        });
    }
}
