<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $anonim = $request->boolean('anonim');

        $request->validate([
            'nama'  => $anonim ? 'nullable' : 'required|string|max:100',
            'email' => $anonim ? 'nullable' : 'required|email|max:100',
            'pesan' => 'required|string|max:2000',
        ]);

        $nama  = $anonim ? 'Anonim' : $request->nama;
        $email = $anonim ? null : $request->email;

        $admins = User::whereHas('roles', fn($q) =>
            $q->whereIn('slug', ['superadmin', 'kesiswaan', 'guru-bk', 'wali-kelas'])
        )->get();

        if ($admins->isNotEmpty()) {
            NotificationService::pesanKontak(
                $nama,
                $email,
                $request->pesan,
                $admins
            );
        }

        return response()->json(['message' => 'Pesan berhasil dikirim.']);
    }
}