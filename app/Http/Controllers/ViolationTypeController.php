<?php

namespace App\Http\Controllers;

use App\Models\ViolationType;
use Illuminate\Http\Request;

class ViolationTypeController extends Controller
{
    public function index()
    {
        return view('pages.administrator.master-data-page.case');
    }

    public function list()
    {
        return response()->json(ViolationType::orderBy('category')->orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:Verbal,Non-Verbal',
            'description' => 'nullable|string',
        ]);

        $record = ViolationType::updateOrCreate(['id' => $request->id], $data);
        return response()->json(['status' => 'success', 'data' => $record]);
    }

    public function destroy($id)
    {
        ViolationType::destroy($id);
        return response()->json(['status' => 'success']);
    }
}