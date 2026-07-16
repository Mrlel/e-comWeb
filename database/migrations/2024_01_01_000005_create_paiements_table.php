<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->cascadeOnDelete();
            $table->string('reference_paiement')->unique();
            $table->decimal('montant', 10, 2);
            $table->string('methode')->default('mobile_money'); // mobile_money, carte, etc.
            $table->enum('statut', ['en_attente', 'réussi', 'échoué'])->default('en_attente');
            $table->string('provider')->default('geniuspay');
            $table->string('transaction_id')->nullable(); // retourné par GeniusPay
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
