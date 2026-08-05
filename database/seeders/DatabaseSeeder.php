<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Admin
        User::updateOrCreate(
            ['email' => 'adminDonato@ncip.com'],
            [
                'name' => 'Admin Donato',
                'password' => Hash::make('NCIPadminBumacas'),
                'role' => 'admin',
            ]
        );

        // ✅ Staff
        User::updateOrCreate(
            ['email' => 'staff@ncip.com'],
            [
                'name' => 'Staff Account',
                'password' => Hash::make('NCIPstaff123'),
                'role' => 'staff',
            ]
        );

        // ✅ Indigenous Person (IP)
        User::updateOrCreate(
            ['email' => 'ipuser@ncip.com'],
            [
                'name' => 'Indigenous Juan',
                'password' => Hash::make('NCIPip123'),
                'role' => 'ip',
            ]
        );

        // ✅ Tribes
        $this->call(TribeSeeder::class);

        // ✅ Accomplishments
        $this->call(AccomplishmentSeeder::class);
    }
}
