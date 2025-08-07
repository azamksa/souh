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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->unsigned()->check('rating >= 1 and rating <= 5');
            $table->text('review')->nullable();
            $table->timestamps();
            
            // منع المستخدم من تقييم نفس الرحلة أكثر من مرة
            $table->unique(['user_id', 'trip_id']);
        });
        
        // إضافة عمود متوسط التقييم للرحلات
        Schema::table('trips', function (Blueprint $table) {
            $table->decimal('average_rating', 3, 2)->default(0)->after('is_active');
            $table->integer('total_ratings')->default(0)->after('average_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['average_rating', 'total_ratings']);
        });
        
        Schema::dropIfExists('ratings');
    }
};