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
        $moderator = Role::firstOrCreate(['name' => 'moderator']);
        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $student = Role::firstOrCreate(['name' => 'student']);

        $user = User::where('email', 'admin@example.com')->first();
        
        if ($user) {
            $user->assignRole('moderator');
        }

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