<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_findings', function (Blueprint $table) {
            $table->id();
            $table->string('reference_code')->unique();
            $table->foreignId('application_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('reporter_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('application_name');
            $table->string('application_url')->nullable();
            $table->string('owner');
            $table->string('title');
            $table->string('finding_type');
            $table->string('category')->default('Keamanan Aplikasi');
            $table->string('severity', 20)->default('Medium');
            $table->string('source');
            $table->dateTime('found_at');
            $table->text('description');
            $table->text('impact')->nullable();
            $table->text('recommendation')->nullable();
            $table->string('status', 40)->default('Baru')->index();
            $table->date('deadline')->nullable();
            $table->string('pic_name')->nullable();
            $table->string('pic_email')->nullable();
            $table->text('internal_note')->nullable();
            $table->text('follow_up')->nullable();
            $table->timestamp('notified_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->index(['severity', 'status']);
            $table->index(['owner', 'found_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_findings');
    }
};
