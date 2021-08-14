<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fundreports', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->text('notes');
            $table->integer('debit');
            $table->string('source');
            $table->integer('kredit');
            $table->integer('saldo');
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
        Schema::dropIfExists('fundreports');
    }
}
