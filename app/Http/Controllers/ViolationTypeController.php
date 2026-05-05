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
            'category' => 'required|in:Verbal,Fisik',
            'description' => 'nullable|string',
            'weight'      => 'nullable|integer|min:1|max:20',
            'keywords'    => 'nullable|string|max:1000',
        ]);

        $record = ViolationType::updateOrCreate(['id' => $request->id], $data);
        return response()->json(['status' => 'success', 'data' => $record]);
    }

    public function destroy($id)
    {
        ViolationType::destroy($id);
        return response()->json(['status' => 'success']);
    }
    public function autocomplete(Request $request)
    {
        $q = trim($request->query('q', ''));
        $query = ViolationType::orderBy('category')->orderBy('name');

        if (strlen($q) >= 1) {
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('keywords', 'like', "%{$q}%");
            });
        }

        // Kalau ada query q, batasi 10. Kalau tidak ada (load semua), ambil semua
        if (strlen($q) >= 1) {
            $query->limit(10);
        }

        return response()->json(
            $query->get(['id', 'name', 'category', 'weight', 'keywords'])
        );
    }
}