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
        Schema::create('alias_funds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->unsignedBigInteger('fund_id');
            $table->foreign('fund_id')->references('id')->on('funds');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alias_funds');
    }
};
