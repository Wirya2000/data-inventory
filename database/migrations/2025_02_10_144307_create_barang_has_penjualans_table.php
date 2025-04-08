<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangHasPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs_has_penjualans', function (Blueprint $table) {
            $table->foreignId('barangs_id')->constrained('barangs');
            $table->foreignId('penjualans_id')->constrained('penjualans');
            $table->integer('jumlah');
            $table->integer('harga_satuan');
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
        Schema::dropIfExists('barang_has_penjualans');
    }
}
