<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            //Kategori donasi, 1:money, 2: barang
            $table->integer('category')->comment('1 for money, 2 for barang')->default(1);
            $table->string('bukti');
            $table->string('jenis_barang_or_jumlah_bayar')->nullable();
            $table->text('notes')->nullable();
            $table->text('address')->nullable();
            //Kategori verification, 1:verified, 2: not valid, 3:not yet verify
            $table->integer('verification')->comment('1:verified, 2: not valid, 3:not yet verify')->default(3);

            $table->unsignedBigInteger('donator_id');
            $table->timestamps();

            $table->foreign('donator_id')->references('id')->on('donators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations');
    }
}
