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
            $table->foreignId('villa_id')->constrained('villas')->onDelete('cascade');
            $table->string('name');
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['income', 'expense']);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->date('date');
            $table->boolean('is_recurring')->default(false);
            $table->foreignId('recurring_id')->nullable()->constrained('recurring_transactions')->onDelete('set null');
            $table->timestamps();
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
