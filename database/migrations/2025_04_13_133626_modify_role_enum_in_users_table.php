<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModifyRoleEnumInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Alter the 'role' column to include 'recipeOwner'
        DB::statement("ALTER TABLE users MODIFY role ENUM('user', 'recipeOwner', 'admin') NOT NULL DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert the 'role' column back to only 'user' and 'admin'
        DB::statement("ALTER TABLE users MODIFY role ENUM('user', 'admin') NOT NULL DEFAULT 'user'");
    }
}
