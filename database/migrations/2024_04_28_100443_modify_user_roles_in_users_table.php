<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->boolean('is_normal_user')->default(true);
            $table->boolean('is_admin')->default(false);
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user');
            $table->dropColumn('is_normal_user');
            $table->dropColumn('is_admin');
        });
    }
};
