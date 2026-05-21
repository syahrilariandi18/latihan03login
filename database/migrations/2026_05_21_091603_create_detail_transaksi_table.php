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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            
            // Otomatis terhubung ke tabel 'transactions' di atas
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
            
            // Otomatis terhubung ke tabel 'products' (pastikan nama tabel produkmu nanti 'products')
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            
            $table->integer('qty');
            $table->decimal('harga', 15, 2); // Harga barang saat transaksi terjadi
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
