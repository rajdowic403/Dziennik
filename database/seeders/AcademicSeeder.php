<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\ClassGroup;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AcademicSeeder extends Seeder
{
    public function run(): void
    {
        
        $subjects = [
    ['name' => 'Programowanie Obiektowe', 'code' => 'PROG-OBJ-01'],
    ['name' => 'Architektura Systemów IT', 'code' => 'ARCH-IT-02'],
    ['name' => 'Bazy Danych SQL', 'code' => 'SQL-DB-03'],
    ['name' => 'Inżynieria Oprogramowania', 'code' => 'SOFT-ENG-04'],
];

        foreach ($subjects as $s) {
            Subject::create($s);
        }

       
        $groups = [
            ['name' => 'GR-L01-INF'], 
            ['name' => 'GR-L02-INF'],
            ['name' => 'GR-PROJ-01'],
        ];

        foreach ($groups as $g) {
            $createdGroups[] = ClassGroup::create($g);
        }

        
        $lecturers = [
            ['name' => 'dr hab. Janusz Kowalski', 'email' => 'j.kowalski@uczelnia.edu.pl'],
            ['name' => 'dr inż. Anna Nowak', 'email' => 'a.nowak@uczelnia.edu.pl'],
        ];

        foreach ($lecturers as $l) {
            $user = User::create([
                'name' => $l['name'],
                'email' => $l['email'],
                'password' => Hash::make('password'),
            ]);
          
            $user->assignRole('teacher'); 
        }

        Role::firstOrCreate(['name' => 'student']);

        $students = [
            'Kamil Majewski', 'Anna Wiśniewska', 'Piotr Zieliński', 'Zofia Kaczmarek',
            'Jan Kowalczyk', 'Katarzyna Szymańska', 'Michał Woźniak', 'Karolina Dąbrowska',
            'Jakub Kozłowski', 'Oliwia Jankowska', 'Maciej Mazur', 'Julia Krawczyk'
        ];

        foreach ($students as $index => $name) {
            // Rozdzielamy studentów równomiernie do grup zapisanych wcześniej
            $group = $createdGroups[$index % count($createdGroups)];

            $studentUser = User::create([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . '@student.uczelnia.edu.pl',
                'password' => Hash::make('password'),
                'class_group_id' => $group->id 
            ]);

            $studentUser->assignRole('student');
        }
    }
}