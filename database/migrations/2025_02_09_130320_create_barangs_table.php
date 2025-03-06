<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20);
            $table->string('nama', 200);
            $table->enum('satuan', ['pcs', 'kg', 'liter']);
            $table->integer('stock');
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->foreignId('kategoris_id')->constrained('kategoris');
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
        Schema::dropIfExists('barangs');
    }
}
