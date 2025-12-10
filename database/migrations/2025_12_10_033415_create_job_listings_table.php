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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->string('description');
            $table->string('qualifications');
            $table->enum('type', ['Full-Time', 'Part-Time', 'Internship'])->default('Full-Time');
            $table->enum('arrangement', ['On-Site', 'Remote', 'Hybrid'])->default('On-Site');
            $table->enum('status', ['Active', 'Closed'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
