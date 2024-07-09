<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use App\Models\Course;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // both concentrations
        $concentration = array();
        $concentration[0] = 'Software Engineering';
        $concentration[1] = 'Artificial Intelligence';

        // software engineering
        $softwareEngineering = array();
        $softwareEngineering[0] = 'Software Engineering';

        // artificial intelligence
        $artificialIntelligence = array();
        $artificialIntelligence[0] = 'Artificial Intelligence';


        User::factory()->create([
            'name' => 'Test User',
            'isAdvisor' => 1,
            'email' => 'test@example.com',
            'password' => Hash::make('P4ssW0rd4269'),
        ]);

        Course::factory()->create([
            'code' => 'COSC 1P02',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'minimumGrade' => 60,
            'name' => 'Introduction to Computer Science',
            'isRequiredByMajor' => 'COSC',
        ]);

        $prereq = array();
        $prereq['COSC 1P02'] = "Introduction to Computer Science";

        Course::factory()->create([
            'code' => 'COSC 1P03',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'minimumGrade' => 60,
            'name' => 'Introduction to Data Structures',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
        ]);

        Course::factory()->create([
            'code' => 'COSC 1P03',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'name' => 'Introduction to Data Structures',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
        ]);

        Course::factory()->create([
            'code' => 'COSC 1P50',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Integrity & Literacy in the Information Age',
            'isRequiredByMajor' => 'COSC',
        ]);

        Course::factory()->create([
            'code' => 'COSC 1P50',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'name' => 'Integrity & Literacy in the Information Age',
            'isRequiredByMajor' => 'COSC',
        ]);

        Course::factory()->create([
            'code' => 'COSC 1P71',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'name' => 'Essentials of Artificial Intelligence',
            'isRequiredByMajor' => 'COSC',
        ]);

        $prereq = array();
        $prereq['MATH 1P20'] = "Introduction to Mathematics";

        Course::factory()->create([
            'code' => 'MATH 1P66',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Mathematical Reasoning',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
        ]);

        $prereq = array();
        $prereq['MATH 1P20'] = "Introduction to Mathematics";

        Course::factory()->create([
            'code' => 'MATH 1P66',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'name' => 'Mathematical Reasoning',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
        ]);

        Course::factory()->create([
            'code' => 'MATH 1P67',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'minimumGrade' => 60,
            'name' => 'Mathematics for Computer Science',
            'isRequiredByMajor' => 'COSC',
        ]);

        $prereq = array();
        $prereq['COSC 1P03'] = "Introduction to Data Structures";
        $prereq['MATH 1P66'] = "MATH 1P66";
        $prereq['MATH 1P67'] = "MATH 1P67";

        Course::factory()->create([
            'code' => 'COSC 2P03',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'minimumGrade' => 60,
            'name' => 'Advanced Data Structures',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
            'concentration' => $concentration,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'code' => 'COSC 2P05',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'name' => 'Programming Languages',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
            'concentration' => $concentration,
        ]);

        $prereq = array();
        $prereq['COSC 1P03'] = "Introduction to Data Structures";

        Course::factory()->create([
            'code' => 'COSC 2P08',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'name' => 'Programming for Big Data',
            'prereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 1P03'] = "Introduction to Data Structures";

        Course::factory()->create([
            'code' => 'COSC 2P12',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Introduction to Computer Architecture',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'code' => 'COSC 2P13',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'name' => 'Introduction to Operating Systems',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
            'concentration' => $concentration,
        ]);

        $prereq = array();
        $prereq['COSC 1P03'] = "Introduction to Data Structures";

        Course::factory()->create([
            'code' => 'COSC 2P89',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Internet Technologies',
            'prereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 1P03'] = "Introduction to Data Structures";

        Course::factory()->create([
            'code' => 'COSC 2P95',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Programming in C++ with Applications',
            'prereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['MATH 1P20'] = "Introduction to Mathematics";

        Course::factory()->create([
            'code' => 'MATH 1P12',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Applied Linear Algebra',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
        ]);

        $prereq = array();
        $prereq['MATH 1P20'] = "Introduction to Mathematics";

        Course::factory()->create([
            'code' => 'STAT 1P98',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Practical Statistics',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
        ]);

        Course::factory()->create([
            'code' => 'STAT 1P98',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'name' => 'Practical Statistics',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";
        $prereq['COSC 2P13'] = "Introduction to Operating Systems";

        Course::factory()->create([
            'code' => 'COSC 3P01',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Computer Networking',
            'prereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'code' => 'COSC 3P03',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Algorithms',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
            'concentration' => $concentration,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'code' => 'COSC 3P32',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'minimumGrade' => 60,
            'name' => 'Database Systems',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
            'concentration' => $concentration,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'code' => 'COSC 3P71',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Artificial Intelligence',
            'prereqs' => $prereq,
            'minimumGrade' => 60,
            'isRequiredByMajor' => 'COSC',
            'concentration' => $concentration,
        ]);

        Course::factory()->create([
            'code' => 'COSC 3P91',
            'duration' => 'D3',
            'prereqCreditCountMajor' => 2,
            'name' => 'Advanced Object-Oriented Programming',
            'concentration' => $softwareEngineering,
        ]);

        $prereq = array();
        $prereq['COSC 2P13'] = "Introduction to Operating Systems";

        Course::factory()->create([
            'code' => 'COSC 3P93',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Parallel Computing',
        ]);

        Course::factory()->create([
            'code' => 'COSC 3P94',
            'duration' => 'D3',
            'prereqCreditCountMajor' => 2,
            'name' => 'Human Computer Interaction',
            'concentration' => $softwareEngineering,
        ]);

        $prereq = array();
        $prereq['COSC 3P71'] = "Artificial Intelligence";

        Course::factory()->create([
            'code' => 'COSC 3P96',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'name' => 'Machine Learning',
            'prereqs' => $prereq,
            'concentration' => $artificialIntelligence,
        ]);

        $prereq = array();
        $prereq['COSC 2P13'] = "Introduction to Operating Systems";
        $prereq['COSC 3P32'] = "Database Systems";

        Course::factory()->create([
            'code' => 'COSC 3P97',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Mobile Computing',
            'prereqs' => $prereq,
            'concentration' => $softwareEngineering,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'code' => 'COSC 3P99',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Computing Project',
            'prereqs' => $prereq,
            'concentration' => $concentration,
        ]);

        Course::factory()->create([
            'code' => 'COSC 3P99',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'name' => 'Computing Project',
            'prereqs' => $prereq,
            'concentration' => $concentration,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'code' => 'COSC 3Q95',
            'duration' => 'D1',
            'prereqCreditCount' => 0,
            'name' => 'Internship in Game Programming',
            'prereqs' => $prereq,
        ]);

        Course::factory()->create([
            'code' => 'COSC 3Q95',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'name' => 'Internship in Game Programming',
            'prereqs' => $prereq,
        ]);

        $prereq = array();
        $prereq['MATH 1P20'] = "Introduction to Mathematics";

        Course::factory()->create([
            'code' => 'MATH 1P05',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Applied Calculus I',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
        ]);

        Course::factory()->create([
            'code' => 'MATH 1P05',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'name' => 'Applied Calculus I',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
        ]);

        $prereq = array();
        $prereq['MATH 1P05'] = "Applied Calculus I";

        Course::factory()->create([
            'code' => 'MATH 1P06',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'name' => 'Applied Calculus II',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";

        Course::factory()->create([
            'code' => 'COSC 4F90',
            'duration' => 'D1',
            'prereqCreditCount' => 10,
            'name' => 'Computing Project',
            'prereqs' => $prereq,
            'concentration' => $concentration,
        ]);

        Course::factory()->create([
            'code' => 'COSC 4F90',
            'duration' => 'D3',
            'prereqCreditCount' => 10,
            'name' => 'Computing Project',
            'prereqs' => $prereq,
            'concentration' => $concentration,
        ]);

        $prereq = array();
        $prereq['COSC 2P03'] = "Advanced Data Structures";
        $prereq['COSC 3P32'] = "Database Systems";

        Course::factory()->create([
            'code' => 'COSC 4P01',
            'duration' => 'D2',
            'prereqCreditCount' => 14,
            'minimumGrade' => 60,
            'name' => 'Software Engineering 1',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
            'concentration' => $concentration,
        ]);

        $prereq = array();
        $prereq['COSC 4P01'] = "Software Engineering 1";

        Course::factory()->create([
            'code' => 'COSC 4P02',
            'duration' => 'D3',
            'prereqCreditCount' => 14,
            'name' => 'Software Engineering 2',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
            'concentration' => $concentration,
        ]);

        $prereq = array();
        $prereq['COSC 3P03'] = "Algorithms";

        Course::factory()->create([
            'code' => 'COSC 4P03',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'name' => 'Advanced Algorithms',
            'prereqs' => $prereq,
            'concentration' => $softwareEngineering,
        ]);

        Course::factory()->create([
            'code' => 'COSC 4P41',
            'duration' => 'D2',
            'prereqCreditCountMajor' => 3.5,
            'name' => 'Functional Programming',
        ]);

        $prereq = array();
        $prereq['MATH 1P67'] = "Math 1P67";

        Course::factory()->create([
            'code' => 'COSC 4P42',
            'duration' => 'D2',
            'prereqCreditCountMajor' => 3.5,
            'name' => 'Formal Methods in Software Engineering',
            'prereqs' => $prereq,
            'concentration' => $softwareEngineering,
        ]);

        Course::factory()->create([
            'code' => 'COSC 4P50',
            'duration' => 'D3',
            'prereqCreditCountMajor' => 3.5,
            'name' => 'Introduction to Cyber Security',
        ]);

        $prereq = array();
        $prereq['MATH 1P67'] = "Math 1P67";

        Course::factory()->create([
            'code' => 'COSC 4P61',
            'duration' => 'D2',
            'prereqCreditCountMajor' => 3.5,
            'name' => 'Theory of Computation',
            'prereqs' => $prereq,
            'isRequiredByMajor' => 'COSC',
            'concentration' => $concentration,
        ]);

        $prereq = array();
        $prereq['COSC 3P71'] = "Artificial Intelligence";

        Course::factory()->create([
            'code' => 'COSC 4P78',
            'duration' => 'D3',
            'prereqCreditCount' => 0,
            'minimumGrade' => 60,
            'name' => 'Robotics',
            'prereqs' => $prereq,
            'concentration' => $artificialIntelligence,
        ]);

        $prereq = array();
        $prereq['COSC 3P71'] = "Artificial Intelligence";

        Course::factory()->create([
            'code' => 'COSC 4P80',
            'duration' => 'D2',
            'prereqCreditCount' => 0,
            'name' => 'Artificial Neural Networks',
            'prereqs' => $prereq,
            'concentration' => $artificialIntelligence,
        ]);

        $coursesCompleted = array();
        $coursesCompleted['COSC 1P02'] = "COSC 1P02";
        $coursesCompleted['COSC 1P03'] = "COSC 1P03";
        $coursesCompleted['COSC 1P50'] = "COSC 1P50";
        $coursesCompleted['ECON 1P91'] = "ECON 1P91";
        $coursesCompleted['MATH 1P66'] = "MATH 1P66";
        $coursesCompleted['MATH 1P67'] = "MATH 1P67";
        $coursesCompleted['COSC 2P12'] = "COSC 2P12";
        $coursesCompleted['COSC 2P03'] = "COSC 2P03";
        $coursesCompleted['COSC 2P13'] = "COSC 2P13";
        $coursesCompleted['COSC 2P89'] = "COSC 2P89";
        $coursesCompleted['COSC 3P71'] = "COSC 3P71";

        Student::factory()->create([
            'name' => 'Thomas Anderson',
            'number' => 1234567,
            'major' => 'COSC',
            'concentration' => 'Artificial Intelligence',
            'coursesCompleted' => $coursesCompleted,
        ]);

    }
}
