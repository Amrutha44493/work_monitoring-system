<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'team_leader']);
        Role::create(['name' => 'employee']);

        // Create admin user
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@kitchen.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole('admin');

        // Create team leader
        $tl = User::create([
            'name'     => 'Team Leader',
            'email'    => 'tl@kitchen.com',
            'password' => Hash::make('password123'),
        ]);
        $tl->assignRole('team_leader');
    }
}