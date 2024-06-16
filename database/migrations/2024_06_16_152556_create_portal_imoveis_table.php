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
        Schema::create('portal_imoveis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('imovel');
            $table->unsignedInteger('portal');

            $table->timestamps();

            $table->foreign('imovel')->references('id')->on('properties')->onDelete('CASCADE');
            $table->foreign('portal')->references('id')->on('portais')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_imoveis');
    }
};
