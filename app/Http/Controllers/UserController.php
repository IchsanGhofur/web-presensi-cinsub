<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'nim'  => $request->nim,
        ]);

        return redirect('/users');
    }
    public function destroy(User $user)
    {
        $hasAttendance = \App\Models\Attendance::where(
            'user_id',
            $user->id
        )->exists();
    
        if ($hasAttendance) {
    
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Peserta tidak dapat dihapus karena sudah memiliki riwayat presensi.'
                );
        }
    
        $user->delete();
    
        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Peserta berhasil dihapus.'
            );
    }
}