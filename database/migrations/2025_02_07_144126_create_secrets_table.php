<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('secrets', function (Blueprint $table) {
            $table->uuid();
            $table->foreignIdFor(User::class)->nullable();
            $table->text('content')->comment('The secret content');
            $table->string('password')->nullable()->comment('Optional password to view the secret');
            $table->string('recipient')->nullable()->comment('Optional email to send the secret');
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secrets');
    }
};
