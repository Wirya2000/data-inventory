<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_penjualan_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_penjualans_id')
                ->constrained('detail_penjualans')
                ->onDelete('cascade');

            $table->foreignId('detail_pembelians_id')
                ->constrained('detail_pembelians')
                ->onDelete('cascade');
            $table->decimal('qty_diambil', 15, 2);
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('subtotal_modal', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs_has_penjualans_batches');
    }
};
