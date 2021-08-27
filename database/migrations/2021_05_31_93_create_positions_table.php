<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leader');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('jabatan_id');
            $table->unsignedBigInteger('periode_id');
            $table->timestamps();

            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('leader')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jabatan_id')->references('id')->on('jabatans')->onDelete('cascade');
            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions');
    }
}
