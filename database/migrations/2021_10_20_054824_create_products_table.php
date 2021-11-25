<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id');
            $table->string('title')->unique();
            $table->string('slug');
            $table->integer('stok');
            $table->string('jumlah_halaman');
            $table->string('penerbit');
            $table->string('tanggal_terbit');
            $table->float('berat');
            $table->float('lebar');
            $table->string('bahasa');
            $table->float('panjang');
            $table->bigInteger('price');
            $table->text('deskripsi_product');
            $table->string('image');
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
        Schema::dropIfExists('products');
    }
}
