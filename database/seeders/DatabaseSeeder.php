<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use App\Models\Course;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'isAdvisor' => 'true',
            'email' => 'test@example.com',
            'password' => Hash::make('P4ssW0rd4269'),
        ]);

        Course::factory()->create([
            'courseCode' => 'COSC 1P02',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Introduction to Computer Science',
        ]);

        $prereq = array();
        $prereq['COSC 1P02'] = "Introduction to Computer Science";

        Course::factory()->create([
            'courseCode' => 'COSC 1P03',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Introduction to Data Structures',
            'coursePrereqs' => $prereq,
        ]);

        Course::factory()->create([
            'courseCode' => 'COSC 1P03',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Introduction to Data Structures',
            'coursePrereqs' => $prereq,
        ]);

        Course::factory()->create([
            'courseCode' => 'COSC 1P50',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Integrity & Literacy in the Information Age',
        ]);

        Course::factory()->create([
            'courseCode' => 'COSC 1P50',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Integrity & Literacy in the Information Age',
        ]);

        Course::factory()->create([
            'courseCode' => 'COSC 1P71',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Essentials of Artificial Intelligence',
        ]);

        $prereq = array();
        $prereq['MATH 1P20'] = "Introduction to Mathematics";

        Course::factory()->create([
            'courseCode' => 'MATH 1P66',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Mathematical Reasoning',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['MATH 1P20'] = "Introduction to Mathematics";

        Course::factory()->create([
            'courseCode' => 'MATH 1P66',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Mathematical Reasoning',
            'coursePrereqs' => $prereq,
        ]);

        Course::factory()->create([
            'courseCode' => 'MATH 1P67',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Mathematics for Computer Science',
        ]);

        $prereq = array();
        $prereq['COSC 1P03'] = "Introduction to Data Structures";
        $prereq['MATH 1P66'] = "MATH 1P66";
        $prereq['MATH 1P67'] = "MATH 1P67";

        Course::factory()->create([
            'courseCode' => 'COSC 2P03',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Advanced Data Structures',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'courseCode' => 'COSC 2P05',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Programming Languages',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 1P03'] = "Introduction to Data Structures";

        Course::factory()->create([
            'courseCode' => 'COSC 2P08',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Programming for Big Data',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 1P03'] = "Introduction to Data Structures";

        Course::factory()->create([
            'courseCode' => 'COSC 2P12',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Introduction to Computer Architecture',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'courseCode' => 'COSC 2P13',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Introduction to Operating Systems',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 1P03'] = "Introduction to Data Structures";

        Course::factory()->create([
            'courseCode' => 'COSC 2P89',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Internet Technologies',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 1P03'] = "Introduction to Data Structures";

        Course::factory()->create([
            'courseCode' => 'COSC 2P95',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Programming in C++ with Applications',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['MATH 1P20'] = "Introduction to Mathematics";

        Course::factory()->create([
            'courseCode' => 'MATH 1P12',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Applied Linear Algebra',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['MATH 1P20'] = "Introduction to Mathematics";

        Course::factory()->create([
            'courseCode' => 'STAT 1P98',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Practical Statistics',
            'coursePrereqs' => $prereq,
        ]);

        Course::factory()->create([
            'courseCode' => 'STAT 1P98',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Practical Statistics',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";
        $prereq['COSC 2P13'] = "Introduction to Operating Systems";

        Course::factory()->create([
            'courseCode' => 'COSC 3P01',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Computer Networking',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'courseCode' => 'COSC 3P03',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Algorithms',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'courseCode' => 'COSC 3P32',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Database Systems',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'courseCode' => 'COSC 3P71',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Artificial Intelligence',
            'coursePrereqs' => $prereq,
        ]);

        Course::factory()->create([
            'courseCode' => 'COSC 3P91',
            'courseDuration' => 'D3',
            'prereqMajorCredits' => 2,
            'courseName' => 'Advanced Object-Oriented Programming',
        ]);

        $prereq = array();
        $prereq['COSC 2P13'] = "Introduction to Operating Systems";

        Course::factory()->create([
            'courseCode' => 'COSC 3P93',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Parallel Computing',
            'coursePrereqs' => $prereq,
        ]);

        Course::factory()->create([
            'courseCode' => 'COSC 3P94',
            'courseDuration' => 'D3',
            'prereqMajorCredits' => 2,
            'courseName' => 'Human Computer Interaction',
        ]);

        $prereq = array();
        $prereq['COSC 3P71'] = "Artificial Intelligence";

        Course::factory()->create([
            'courseCode' => 'COSC 3P96',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Machine Learning',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 2P13'] = "Introduction to Operating Systems";
        $prereq['COSC 3P32'] = "Database Systems";

        Course::factory()->create([
            'courseCode' => 'COSC 3P97',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Mobile Computing',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'courseCode' => 'COSC 3P99',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Computing Project',
            'coursePrereqs' => $prereq,
        ]);

        Course::factory()->create([
            'courseCode' => 'COSC 3P99',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Computing Project',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'courseCode' => 'COSC 3Q95',
            'courseDuration' => 'D1',
            'prereqCredits' => 0,
            'courseName' => 'Internship in Game Programming',
            'coursePrereqs' => $prereq,
        ]);

        Course::factory()->create([
            'courseCode' => 'COSC 3Q95',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Internship in Game Programming',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['MATH 1P20'] = "Introduction to Mathematics";

        Course::factory()->create([
            'courseCode' => 'MATH 1P05',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Applied Calculus I',
            'coursePrereqs' => $prereq,
        ]);

        Course::factory()->create([
            'courseCode' => 'MATH 1P05',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Applied Calculus I',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['MATH 1P05'] = "Applied Calculus I";

        Course::factory()->create([
            'courseCode' => 'MATH 1P06',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Applied Calculus II',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'courseCode' => 'COSC 4F90',
            'courseDuration' => 'D1',
            'prereqCredits' => 10,
            'courseName' => 'Computing Project',
            'coursePrereqs' => $prereq,
        ]);

        Course::factory()->create([
            'courseCode' => 'COSC 4F90',
            'courseDuration' => 'D3',
            'prereqCredits' => 10,
            'courseName' => 'Computing Project',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";
        $prereq['COSC 3P32'] = "Database Systems";

        Course::factory()->create([
            'courseCode' => 'COSC 4P01',
            'courseDuration' => 'D2',
            'prereqCredits' => 14,
            'courseName' => 'Software Engineering 1',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 4P01'] = "Software Engineering 1";

        Course::factory()->create([
            'courseCode' => 'COSC 4P02',
            'courseDuration' => 'D3',
            'prereqCredits' => 14,
            'courseName' => 'Software Engineering 2',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 3P03'] = "Algorithms";

        Course::factory()->create([
            'courseCode' => 'COSC 4P03',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Advanced Algorithms',
            'coursePrereqs' => $prereq,
        ]);

        Course::factory()->create([
            'courseCode' => 'COSC 4P41',
            'courseDuration' => 'D2',
            'prereqMajorCredits' => 3.5,
            'courseName' => 'Functional Programming',
        ]);

        $prereq = array();
        $prereq['MATH 1P67'] = "Math 1P67";

        Course::factory()->create([
            'courseCode' => 'COSC 4P42',
            'courseDuration' => 'D2',
            'prereqMajorCredits' => 3.5,
            'courseName' => 'Formal Methods in Software Engineering',
            'coursePrereqs' => $prereq,
        ]);

        Course::factory()->create([
            'courseCode' => 'COSC 4P50',
            'courseDuration' => 'D3',
            'prereqMajorCredits' => 3.5,
            'courseName' => 'Introduction to Cyber Security',
        ]);

        $prereq = array();
        $prereq['MATH 1P67'] = "Math 1P67";

        Course::factory()->create([
            'courseCode' => 'COSC 4P61',
            'courseDuration' => 'D2',
            'prereqMajorCredits' => 3.5,
            'courseName' => 'Theory of Computation',
            'coursePrereqs' => $prereq,
        ]);



        $prereq = array();
        $prereq['COSC 3P71'] = "Artificial Intelligence";

        Course::factory()->create([
            'courseCode' => 'COSC 4P78',
            'courseDuration' => 'D3',
            'prereqCredits' => 0,
            'courseName' => 'Robotics',
            'coursePrereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 3P71'] = "Artificial Intelligence";

        Course::factory()->create([
            'courseCode' => 'COSC 4P80',
            'courseDuration' => 'D2',
            'prereqCredits' => 0,
            'courseName' => 'Artificial Neural Networks',
            'coursePrereqs' => $prereq,
        ]);

        $coursesCompleted = array();
        $coursesCompleted['COSC 1P02'] = "COSC 1P02";

        Student::factory()->create([
            'studentName' => 'Thomas Anderson',
            'studentNumber' => 1234567,
            'coursesCompleted' => $coursesCompleted,
        ]);

    }
}
