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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');//by default laravel search migration file with plural form of user
            $table->foreignId('job_id')->constrained('tbl_jobs')->onDelete('cascade');//Here constrained is used for specify the table
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('applied_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
