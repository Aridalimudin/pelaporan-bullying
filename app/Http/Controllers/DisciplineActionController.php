<?php

namespace App\Http\Controllers;

use App\Models\DisciplineAction;
use Illuminate\Http\Request;

class DisciplineActionController extends Controller
{
    public function index()
    {
        return view('pages.administrator.master-data-page.disciplinary');
    }

    public function list()
    {
        return response()->json(
            DisciplineAction::orderByRaw("FIELD(level,'Ringan','Sedang','Berat')")
                ->orderBy('name')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'level'              => 'required|in:Ringan,Sedang,Berat',
            'duration'           => 'nullable|string|max:100',
            'executor'           => 'nullable|string|max:100',
            'description'        => 'nullable|string',
            'condition'          => 'nullable|string',
            'parent_involvement' => 'nullable|in:tidak,ya,opsional',
        ]);

        $record = DisciplineAction::updateOrCreate(['id' => $request->id], $data);
        return response()->json(['status' => 'success', 'data' => $record]);
    }

    public function destroy($id)
    {
        DisciplineAction::destroy($id);
        return response()->json(['status' => 'success']);
    }
}