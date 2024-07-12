<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePermissionsTable extends Migration
{
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            // $table->renameColumn('permission_name', 'name');
            $table->string('code')->after('name');
        });
    }

    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            // $table->renameColumn('name', 'permission_name');
            $table->dropColumn('code');
        });
    }
}
