<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class StudentController extends Controller
{
    /* ════════════════════════════════
       PAGE
    ════════════════════════════════ */

    public function index()
    {
        return view('pages.administrator.master-data-page.students');
    }

    /* ════════════════════════════════
       STUDENTS
    ════════════════════════════════ */

    public function getStudents()
    {
        $students = Student::orderBy('fullname')->get();
        $mapped = $students->map(function ($s) {
            return [
                'id'             => $s->id,
                'fullname'       => $s->fullname,
                'nis'            => $s->nis,
                'grade'          => $s->grade,
                'major'          => $s->major,
                'gender'         => $s->gender,
                'phone'          => $s->phone,
                'email'          => $s->email,
                'is_active'      => $s->is_active,
                'report_history' => $s->report_history ?? 0,
                'has_password'   => !empty($s->password),
                'plain_password' => $s->plain_password ?? null,  // untuk tampilan admin
            ];
        });
        return response()->json($mapped);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        if (isset($input['password']) && trim($input['password']) === '') {
            unset($input['password']);
        }

        $validator = \Illuminate\Support\Facades\Validator::make($input, [
            'fullname' => 'required|string|max:255',
            'nis'      => 'required|string|unique:students,nis,' . ($request->id ?? 'NULL'),
            'grade'    => 'required|string',
            'major'    => 'required|string',
            'gender'   => 'required|in:L,P',
            'phone'    => 'required|string|max:20',
            'email'    => 'required|email|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $data = $validator->validate();

        // Pastikan kolom password, plain_password & is_active sudah ada di tabel students
        if (! Schema::hasColumn('students', 'password')) {
            try {
                Schema::table('students', function (Blueprint $table) {
                    $table->string('password')->nullable();
                    $table->string('plain_password')->nullable();
                    $table->boolean('is_active')->default(true);
                    $table->rememberToken();
                });
            } catch (\Throwable $e) { /* abaikan jika sudah ada */ }
        }
        if (! Schema::hasColumn('students', 'plain_password')) {
            try {
                Schema::table('students', function (Blueprint $table) {
                    $table->string('plain_password')->nullable()->after('password');
                });
            } catch (\Throwable $e) { /* abaikan jika sudah ada */ }
        }

        if (! empty($data['password'])) {
            $data['plain_password'] = $data['password'];  // simpan plaintext untuk admin
            $data['password']       = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $student = Student::updateOrCreate(['id' => $request->id], $data);
        return response()->json(['status' => 'success', 'data' => $student]);
    }

    public function destroy($id)
    {
        Student::destroy($id);
        return response()->json(['status' => 'success']);
    }

    public function setPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $student = Student::findOrFail($id);
        $student->update(['password' => bcrypt($request->password)]);

        return response()->json(['status' => 'success', 'message' => 'Password berhasil diset.']);
    }

    public function toggleStatus($id)
    {
        $student = Student::findOrFail($id);
        $student->update(['is_active' => ! $student->is_active]);

        return response()->json([
            'status'    => 'success',
            'is_active' => $student->is_active,
            'message'   => $student->is_active ? 'Akun siswa diaktifkan.' : 'Akun siswa dinonaktifkan.',
        ]);
    }


    /* ════════════════════════════════
       GRADES
    ════════════════════════════════ */

    public function getGrades()
    {
        // Langsung kembalikan datanya (tanpa dibungkus object)
        // agar sesuai dengan format array yang diminta JavaScript
        return response()->json(Student::allGrades());
    }


    public function storeGrade(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:grades,name']);
        Student::addGrade($request->name);
        return response()->json(['status' => 'success']);
    }

    public function destroyGrade($name)
    {
        Student::removeGrade($name);
        return response()->json(['status' => 'success']);
    }

    /* ════════════════════════════════
       MAJORS
    ════════════════════════════════ */

    public function getMajors()
    {
        // Langsung kembalikan datanya (tanpa dibungkus object)
        // agar sesuai dengan format array yang diminta JavaScript
        return response()->json(Student::allMajors());
    }

    public function storeMajor(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:majors,name']);
        Student::addMajor($request->name);
        return response()->json(['status' => 'success']);
    }

    public function destroyMajor($name)
    {
        Student::removeMajor($name);
        return response()->json(['status' => 'success']);
    }
}