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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('reference')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('from_wallet_id');
            $table->string('currency');
            $table->decimal('amount')->default(0);
            $table->decimal('charges')->default(0);
            $table->decimal('total_amount')->default(0);
            $table->string('type');
            $table->decimal('balance_before');
            $table->decimal('balance_after');
            $table->enum('status', ['pending', 'failed', 'success']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
