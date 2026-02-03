<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('renewals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['hosting', 'domain', 'ssl', 'other']);
            $table->string('service_name');
            $table->string('provider')->nullable();
            $table->decimal('cost', 10, 2); // Coût d'achat
            $table->decimal('price', 10, 2); // Prix de vente au client
            $table->decimal('margin', 10, 2); // Marge bénéficiaire
            $table->date('start_date');
            $table->date('renewal_date');
            $table->enum('status', ['active', 'pending', 'expired', 'cancelled'])->default('active');
            $table->boolean('auto_renew')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renewals');
    }
};
