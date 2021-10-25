<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('customer_id');
            $table->string('invoice');
            $table->enum('status', ['pending', 'success', 'expired', 'failed']);
            $table->string('snap_token')->nullable();
            $table->string('phone')->nullable();
            $table->string('full_name')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('address')->nullable();
            $table->string('service')->nullable();
            $table->string('courir')->nullable();
            $table->bigInteger('cost')->nullable();
            $table->bigInteger('grand_total')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
