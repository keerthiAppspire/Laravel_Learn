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
        Schema::create('request_traces', function (Blueprint $table) {
       	  $table->id();
      	  $table->uuid('trace_id')->unique();
       	  $table->string('route_name')->nullable();
          $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
          $table->unsignedBigInteger('tenant_id')->nullable();
          $table->decimal('duration_ms', 10, 2);
          $table->unsignedBigInteger('peak_memory_bytes')->nullable();
          $table->unsignedSmallInteger('status');
          $table->timestamps(); 
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
     	Schema::dropIfExists('request_traces');  
    }
};
