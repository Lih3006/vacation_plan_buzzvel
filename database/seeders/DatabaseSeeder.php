<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        try {
            User::factory(10)->create();
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }


        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $employeeRole = Role::create(['name' => 'employee']);



        $userAdmin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'role_id' => $adminRole->id
        ]);
        $userAdmin->createToken('api_token')->plainTextToken;

        $userManager = User::create([
            'name' => 'manager',
            'email' => 'manager@manager.com',
            'password' => bcrypt('manager'),
            'role_id' => $managerRole->id
        ]);
        $userManager->createToken('api_token')->plainTextToken;

        $userEmployee = User::create([
            'name' => 'employee',
            'email' => 'employee@employee.com',
            'password' => bcrypt('employee'),
            'role_id' => $employeeRole->id
        ]);
        $userEmployee->createToken('api_token')->plainTextToken;

    }
}
