<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use App\Models\ClassGroup;
use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password')
            ]
        );
        $adminUser->assignRole($adminRole);

        $subjectData = [
            ['name' => 'Programowanie Obiektowe', 'code' => 'PROG-OBJ-01'],
            ['name' => 'Architektura Systemów IT', 'code' => 'ARCH-IT-02'],
            ['name' => 'Bazy Danych SQL', 'code' => 'SQL-DB-03'],
        ];

        $createdSubjects = [];
        foreach ($subjectData as $s) {
            $createdSubjects[] = Subject::firstOrCreate(['code' => $s['code']], $s);
        }

        $groupData = [
            ['name' => 'GR-L01-INF'], 
            ['name' => 'GR-L02-INF'],
        ];

        $createdGroups = [];
        foreach ($groupData as $g) {
            $createdGroups[] = ClassGroup::firstOrCreate(['name' => $g['name']], $g);
        }

        $lecturers = [
            ['name' => 'dr hab. Janusz Kowalski', 'email' => 'j.kowalski@uczelnia.edu.pl'],
            ['name' => 'dr inż. Anna Nowak', 'email' => 'a.nowak@uczelnia.edu.pl'],
        ];

        $createdTeachers = [];
        foreach ($lecturers as $l) {
            $user = User::firstOrCreate(
                ['email' => $l['email']],
                [
                    'name' => $l['name'],
                    'password' => Hash::make('password'),
                ]
            );
            $user->assignRole($teacherRole); 
            $createdTeachers[] = $user;
        }

        $studentNames = ['Kamil Majewski', 'Anna Wiśniewska', 'Piotr Zieliński'];
        foreach ($studentNames as $index => $name) {
            $group = $createdGroups[$index % count($createdGroups)];
            $studentUser = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $name)) . '@student.edu.pl'],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'class_group_id' => $group->id 
                ]
            );
            $studentUser->assignRole($studentRole);
        }

        Lesson::create([
            'subject_id' => $createdSubjects[0]->id,
            'teacher_id' => $createdTeachers[0]->id,
            'class_group_id' => $createdGroups[0]->id,
            'start' => Carbon::today()->setHour(10)->setMinute(0)->setSecond(0), 
            'end' => Carbon::today()->setHour(11)->setMinute(30)->setSecond(0), 
        ]);

        Lesson::create([
            'subject_id' => $createdSubjects[2]->id,
            'teacher_id' => $createdTeachers[1]->id,
            'class_group_id' => $createdGroups[0]->id,
            'start' => Carbon::today()->setHour(12)->setMinute(0)->setSecond(0),
            'end' => Carbon::today()->setHour(13)->setMinute(30)->setSecond(0),
        ]);
    }
}