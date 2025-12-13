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
        Schema::create('ms_services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "Poli Gigi", "Poli Anak"
            $table->text('description')->nullable();
            $table->string('code');

            // Kolom JSON ini berisi Array ID dari user dengan Role ID 3 (Staff)
            // Contoh: [3, 4, 5] -> Artinya Staff ID 3, 4, dan 5 bertugas di poli ini
            $table->json('assigned_user_ids')->nullable();

            $table->boolean('is_active')->default(true);
            $table->time('estimated_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_services');
    }
};
