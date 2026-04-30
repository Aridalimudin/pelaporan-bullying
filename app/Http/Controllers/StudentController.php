<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

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
        return response()->json(Student::orderBy('fullname')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fullname' => 'required|string|max:255',
            'nis'      => 'required|string|unique:students,nis,' . $request->id,
            'grade'    => 'required|string',
            'major'    => 'required|string',
            'gender'   => 'required|in:L,P',
            'phone'    => 'required|string|max:20',
            'email'    => 'required|email|max:255',
        ]);

        $student = Student::updateOrCreate(['id' => $request->id], $data);
        return response()->json(['status' => 'success', 'data' => $student]);
    }

    public function destroy($id)
    {
        Student::destroy($id);
        return response()->json(['status' => 'success']);
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