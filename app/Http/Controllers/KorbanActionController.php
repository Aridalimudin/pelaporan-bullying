<?php

namespace App\Http\Controllers;

use App\Models\KorbanAction;
use Illuminate\Http\Request;

class KorbanActionController extends Controller
{
    public function index()
    {
        return response()->json(
            KorbanAction::orderBy('name')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'catatan'     => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama tindakan wajib diisi.',
        ]);

        $record = KorbanAction::create($data);
        return response()->json(['status' => 'success', 'data' => $record]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'catatan'     => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama tindakan wajib diisi.',
        ]);

        $record = KorbanAction::findOrFail($id);
        $record->update($data);

        return response()->json(['status' => 'success', 'data' => $record]);
    }

    public function destroy($id)
    {
        KorbanAction::destroy($id);
        return response()->json(['status' => 'success']);
    }
}
