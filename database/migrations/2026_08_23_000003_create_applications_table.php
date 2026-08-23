<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('owner')->nullable();
            $table->string('service')->nullable();
            $table->string('sector')->nullable();
            $table->string('status')->default('Aktif');
            $table->unsignedSmallInteger('year')->nullable();
            $table->string('url')->nullable();
            $table->string('language')->nullable();
            $table->string('framework')->nullable();
            $table->string('database')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('server')->nullable();
            $table->text('description')->nullable();
            $table->text('operational_unit')->nullable();
            $table->text('integrations')->nullable();
            $table->decimal('development_cost', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
