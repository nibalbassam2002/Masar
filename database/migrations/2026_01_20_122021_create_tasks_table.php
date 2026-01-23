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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('users');
            $table->foreignId('assignee_id')->nullable()->constrained('users'); // الشخص المسؤول
            $table->foreignId('parent_id')->nullable()->constrained('tasks')->onDelete('cascade'); // للـ Sub-tasks
            
            $table->string('title');
            $table->text('description')->nullable();
            
            // الحالات (تتغير حسب نوع المشروع)
            $table->string('status')->default('todo'); // todo, in_progress, review, done
            
            // الأولويات
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            
            // التخصص (هذا ما سيجعله مناسباً لكل الفئات)
            $table->string('category')->nullable(); // e.g., 'Frontend', 'SEO', 'UI Design'
            
            $table->date('due_date')->nullable();
            $table->integer('position')->default(0); // لترتيب المهام في العمود
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
