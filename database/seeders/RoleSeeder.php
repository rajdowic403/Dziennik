<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

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
    }
}