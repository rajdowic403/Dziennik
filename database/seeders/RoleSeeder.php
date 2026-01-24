<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Tworzymy role (jeśli nie istnieją)
        $moderator = Role::firstOrCreate(['name' => 'moderator']);
        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $student = Role::firstOrCreate(['name' => 'student']);

        // Znajdź Twojego użytkownika po emailu i nadaj mu rolę moderatora
        // Zmień poniższy email na ten, którego użyłeś przy rejestracji!
        $user = User::where('email', 'admin@example.com')->first();
        
        if ($user) {
            $user->assignRole('moderator');
        }
    }
}