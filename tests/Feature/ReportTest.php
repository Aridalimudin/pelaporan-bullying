<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class ReportTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Safely insert test grades, majors, and grade_majors if they don't exist
        DB::table('grades')->insertOrIgnore([
            ['name' => 'X', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('majors')->insertOrIgnore([
            ['name' => 'RPL', 'code' => 'RPL', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('grade_majors')->insertOrIgnore([
            ['grade' => 'X', 'major' => 'RPL', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Ensure there is at least one violation type for BullyingClassifier to work
        if (DB::table('violation_types')->count() === 0) {
            DB::table('violation_types')->insert([
                ['name' => 'Ejekan', 'category' => 'Verbal', 'weight' => 2, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }

    public function test_student_autocomplete_endpoint(): void
    {
        // Insert a test student
        $student = Student::create([
            'fullname' => 'Budi Santoso Antigravity',
            'nis' => '999901',
            'grade' => 'X',
            'major' => 'RPL',
            'gender' => 'L',
            'phone' => '081234567890',
            'email' => 'budi.antigravity@siswa.sch.id',
        ]);

        // Query autocomplete with part of name
        $response = $this->getJson('/api/students/autocomplete?q=Antigravity');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.fullname', 'Budi Santoso Antigravity');
    }

    public function test_parent_report_submission(): void
    {
        $response = $this->postJson('/api/reports', [
            'reporter_type' => 'ortu',
            'reporter_name' => 'Slamet Antigravity',
            'reporter_phone' => '08129999999',
            'child_name' => 'Budi Santoso Antigravity',
            'child_grade' => 'X RPL',
            'deskripsi' => 'Anak saya Budi Santoso Antigravity di-bully oleh teman sekelasnya berkali-kali.',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('reports', [
            'reporter_type' => 'ortu',
            'reporter_name' => 'Slamet Antigravity',
            'child_name' => 'Budi Santoso Antigravity',
            'child_grade' => 'X RPL',
        ]);
    }

    public function test_parent_report_submission_with_linked_student(): void
    {
        // Create student
        $student = Student::create([
            'fullname' => 'Budi Santoso Antigravity',
            'nis' => '999901',
            'grade' => 'X',
            'major' => 'RPL',
            'gender' => 'L',
            'phone' => '081234567890',
            'email' => 'budi.antigravity@siswa.sch.id',
        ]);

        $response = $this->postJson('/api/reports', [
            'reporter_type' => 'ortu',
            'reporter_name' => 'Slamet Antigravity',
            'reporter_phone' => '08129999999',
            'child_name' => 'Budi Santoso Antigravity',
            'child_grade' => 'X  RPL',
            'student_id' => $student->id,
            'deskripsi' => 'Anak saya Budi Santoso Antigravity di-bully oleh teman sekelasnya berkali-kali.',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);

        $ticketCode = $response->json('ticket_code');

        $this->assertDatabaseHas('reports', [
            'reporter_type' => 'ortu',
            'reporter_name' => 'Slamet Antigravity',
            'child_name' => 'Budi Santoso Antigravity',
            'child_grade' => 'X  RPL',
            'student_id' => $student->id,
        ]);

        // Get track details
        $trackResponse = $this->getJson('/api/reports/track?code=' . $ticketCode);
        $trackResponse->assertStatus(200)
            ->assertJsonPath('data.student_nis', '999901');
    }
}
