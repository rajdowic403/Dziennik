<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $student = Role::firstOrCreate(['name' => 'student']);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password')
            ]
        );
        $adminUser->assignRole('admin');

        $teachers = ['John Smith',  'Emily Johnson',  'Michael Brown',  'Sarah Williams',  'David Miller',  'Jessica Taylor',  'Daniel Anderson',  'Laura Thompson',  'James Wilson',  'Olivia Moore'
    ];
foreach ($teachers as $name) {
    $user = User::firstOrCreate(
        ['email' => strtolower(str_replace(' ', '.', $name)) . '@szkola.pl'],
        ['name' => $name, 'password' => Hash::make('password')]
    );
    $user->assignRole('teacher');
}
    }
}