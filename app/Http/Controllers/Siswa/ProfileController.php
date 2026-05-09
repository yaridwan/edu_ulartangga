<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Define default avatars available for selection using DiceBear API
        $avatars = [
            'https://api.dicebear.com/7.x/bottts/svg?seed=Felix&backgroundColor=b6e3f4',
            'https://api.dicebear.com/7.x/bottts/svg?seed=Aneka&backgroundColor=ffdfbf',
            'https://api.dicebear.com/7.x/bottts/svg?seed=Oliver&backgroundColor=c0aede',
            'https://api.dicebear.com/7.x/bottts/svg?seed=Ginger&backgroundColor=d1d4f9',
            'https://api.dicebear.com/7.x/bottts/svg?seed=Missy&backgroundColor=ffd5dc',
            'https://api.dicebear.com/7.x/bottts/svg?seed=Tinkerbell&backgroundColor=b6e3f4',
            'https://api.dicebear.com/7.x/bottts/svg?seed=Sammy&backgroundColor=ffdfbf',
            'https://api.dicebear.com/7.x/bottts/svg?seed=Scooter&backgroundColor=c0aede',
            'https://api.dicebear.com/7.x/bottts/svg?seed=Midnight&backgroundColor=d1d4f9',
            'https://api.dicebear.com/7.x/bottts/svg?seed=Mimi&backgroundColor=ffd5dc',
        ];

        return view('siswa.profile.index', compact('user', 'avatars'));
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|string',
        ]);

        $user = auth()->user();
        $user->update(['avatar' => $request->avatar]);

        return back()->with('success', 'Avatar berhasil diperbarui!');
    }
}
