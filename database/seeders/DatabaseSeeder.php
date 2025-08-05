<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إنشاء مستخدم عادي
        User::create([
            'name' => 'أحمد محمد',
            'email' => 'user@sawah.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // إنشاء مستخدم admin
        User::create([
            'name' => 'المدير العام',
            'email' => 'admin@sawah.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // تشغيل seeder الرحلات
        $this->call([
            TripSeeder::class,
        ]);
    }
}