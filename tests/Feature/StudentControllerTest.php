<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    #[Test]
    public function it_displays_student_list()
    {
        $user = User::factory()->create();
        $students = Student::factory()
            ->for($user)
            ->count(3)
            ->create();

        $response = $this->actingAs($user)
            ->get(route('students.index'));

        $response->assertStatus(200)
            ->assertViewIs('students.index')
            ->assertViewHas('students', $students);
    }

    #[Test]
    public function it_displays_student_creation_form()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('students.create'));

        $response->assertStatus(200)
            ->assertViewIs('students.create');
    }

    #[Test]
    public function it_stores_new_student()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'John Doe',
            'number' => '7654321',
            'major' => 'COSC',
            'concentration' => 'Artificial Intelligence',
        ];

        $response = $this->actingAs($user)
            ->post(route('students.store'), $data);

        $response->assertStatus(302)
            ->assertRedirect(route('students.show', Student::where('number', '7654321')->first()));

        $this->assertDatabaseHas('students', $data);
    }

    #[Test]
    public function it_finds_and_displays_student()
    {
        $user = User::factory()->create();
        $student = Student::factory()
            ->for($user)
            ->create();

        $response = $this->actingAs($user)
            ->get(route('students.findStudent', ['number' => $student->number]));

        $response->assertStatus(200)
            ->assertViewIs('students.show')
            ->assertViewHas('student', $student);
    }

    #[Test]
    public function it_shows_student_details()
    {
        $user = User::factory()->create();
        $student = Student::factory()
            ->for($user)
            ->create();

        $response = $this->actingAs($user)
            ->get(route('students.show', $student));

        $response->assertStatus(200)
            ->assertViewIs('students.show')
            ->assertViewHas('student', $student);
    }

    #[Test]
    public function it_displays_edit_form_for_student()
    {
        $user = User::factory()->create();
        $student = Student::factory()
            ->for($user)
            ->create();

        $response = $this->actingAs($user)
            ->get(route('students.edit', $student));

        $response->assertStatus(200)
            ->assertViewIs('students.edit')
            ->assertViewHas('student', $student);
    }

    #[Test]
    public function it_updates_student()
    {
        $user = User::factory()->create();
        $student = Student::factory()
            ->for($user)
            ->create();

        $data = [
            'name' => 'Jane Doe',
            'number' => '7654321',
            'major' => 'COSC',
            'concentration' => 'Software Engineering',
        ];

        $response = $this->actingAs($user)
            ->put(route('students.update', $student), $data);

        $response->assertStatus(302)
            ->assertRedirect(route('students.show', $student));

        $this->assertDatabaseHas('students', $data);
    }

    #[Test]
    public function it_deletes_student()
    {
        $user = User::factory()->create();
        $student = Student::factory()
            ->for($user)
            ->create();

        $response = $this->actingAs($user)
            ->delete(route('students.destroy', $student));

        $response->assertStatus(302)
            ->assertRedirect(route('students.index'));

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }
}
