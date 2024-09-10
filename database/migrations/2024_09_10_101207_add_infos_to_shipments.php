<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->string('name')->nullable(); // Name of the recipient
            $table->string('street_address')->nullable(); // Street Address
            $table->string('street_address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state_or_province')->nullable();
            $table->string('paid_status')->default('unpaid');
            $table->string('delivery_status')->default('not delivered');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipments', function (Blueprint $table) {
            //
        });
    }
};
