<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            //0:Have no access admin, 1: all access
            //2: Web Dev, 3: HR, 4: Marketing and Fundraising
            // 5: Comm and Partner, 6: Project management
            $table->unsignedInteger('permission')->default(0);
            $table->string('password');
            //1:Aktif, 0:not aktif
            $table->integer('status')->comment('1 : aktif, 0:not aktif');
            
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
