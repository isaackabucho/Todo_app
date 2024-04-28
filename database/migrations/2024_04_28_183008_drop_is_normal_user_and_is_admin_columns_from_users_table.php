<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIsNormalUserAndIsAdminColumnsFromUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_normal_user', 'is_admin']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add the columns back in the "down" method if needed
            $table->boolean('is_normal_user')->default(false);
            $table->boolean('is_admin')->default(false);
        });
    }
}