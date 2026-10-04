<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('admin_notifications')) {
            Schema::create('admin_notifications', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('admin_id')->nullable()->comment('null = all admins');
                $table->string('type')->default('order')->comment('order, system, seller, refund');
                $table->string('title');
                $table->string('message');
                $table->string('url')->nullable()->comment('Target URL when clicked');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
                $table->index(['admin_id', 'is_read']);
                $table->index('created_at');
            });
        }

        if (!Schema::hasTable('todos')) {
            Schema::create('todos', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('admin_id');
                $table->string('title');
                $table->text('description')->nullable();
                $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
                $table->enum('status', ['pending', 'in_progress', 'done'])->default('pending');
                $table->date('due_date')->nullable();
                $table->timestamps();
                $table->index(['admin_id', 'status']);
            });
        }

        if (!Schema::hasTable('expense_categories')) {
            Schema::create('expense_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('color')->default('#6b7280');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('expenses')) {
            Schema::create('expenses', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('admin_id');
                $table->unsignedBigInteger('expense_category_id')->nullable();
                $table->string('title');
                $table->text('description')->nullable();
                $table->decimal('amount', 12, 2);
                $table->date('expense_date');
                $table->string('attachment')->nullable();
                $table->timestamps();
                $table->index(['admin_id', 'expense_date']);
            });
        }

        // Courier columns on orders
        if (!Schema::hasColumn('orders', 'courier_name')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('courier_name')->nullable();
                $table->string('courier_tracking_id')->nullable();
                $table->string('courier_status')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
        Schema::dropIfExists('todos');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_categories');
    }
};
