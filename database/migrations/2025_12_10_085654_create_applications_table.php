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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('applied_position');
            $table->string('applicant_last_name', 50);
            $table->string('applicant_first_name', 50);
            $table->string('applicant_middle_name', 50);
            $table->string('applicant_suffix_name', 50)->nullable();
            $table->string('applicant_address', 150);
            $table->string('applicant_email', 150);
            $table->string('applicant_phone', 20);
            $table->string('applicant_resume_file', 255);
            $table->enum('status', ['Not Filtered', 'Filtered'])->default('Not Filtered');
            $table->boolean('agreed_to_terms')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
