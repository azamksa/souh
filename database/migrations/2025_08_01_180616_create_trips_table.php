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
        Schema::table('requests', function (Blueprint $table) {
            $table->text('admin_notes')->nullable()->after('notes');
            $table->timestamp('processed_at')->nullable()->after('admin_notes');
            $table->foreignId('processed_by')->nullable()->constrained('users')->after('processed_at');
        });

        // إضافة حقل is_active للمستخدمين إذا لم يكن موجوداً
        if (!Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('is_admin');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign(['processed_by']);
            $table->dropColumn(['admin_notes', 'processed_at', 'processed_by']);
        });

        if (Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
};