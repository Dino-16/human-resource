<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('filtered_resumes')) {
            Schema::create('filtered_resumes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('application_id')->nullable();
                $table->text('skills')->nullable();
                $table->text('education')->nullable();
                $table->text('experience')->nullable();
                $table->timestamps();
            });
            return;
        }

        Schema::table('filtered_resumes', function (Blueprint $table) {
            if (!Schema::hasColumn('filtered_resumes', 'application_id')) {
                $table->unsignedBigInteger('application_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('filtered_resumes', 'skills')) {
                $table->text('skills')->nullable()->after('application_id');
            }
            if (!Schema::hasColumn('filtered_resumes', 'education')) {
                $table->text('education')->nullable()->after('skills');
            }
            if (!Schema::hasColumn('filtered_resumes', 'experience')) {
                $table->text('experience')->nullable()->after('education');
            }
        });
    }

    public function down(): void
    {
        Schema::table('filtered_resumes', function (Blueprint $table) {
            if (Schema::hasColumn('filtered_resumes', 'experience')) {
                $table->dropColumn('experience');
            }
            if (Schema::hasColumn('filtered_resumes', 'education')) {
                $table->dropColumn('education');
            }
            if (Schema::hasColumn('filtered_resumes', 'skills')) {
                $table->dropColumn('skills');
            }
            if (Schema::hasColumn('filtered_resumes', 'application_id')) {
                $table->dropColumn('application_id');
            }
        });
    }
};
