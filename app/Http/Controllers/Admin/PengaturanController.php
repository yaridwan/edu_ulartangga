<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanAplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanAplikasi::all()->groupBy(function ($item) {
            if (str_contains($item->key, 'poin_') || str_contains($item->key, 'batas_') || str_contains($item->key, 'aturan_')) {
                return 'game';
            }
            if (in_array($item->key, ['suara_aktif', 'musik_aktif'])) {
                return 'audio';
            }
            if (in_array($item->key, ['jumlah_kotak', 'jumlah_ular', 'jumlah_tangga'])) {
                return 'papan';
            }
            return 'umum';
        });

        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token', '_method') as $key => $value) {
            $setting = PengaturanAplikasi::where('key', $key)->first();
            if ($setting) {
                if ($setting->type === 'image' && $request->hasFile($key)) {
                    $path = $request->file($key)->store('pengaturan', 'public');
                    $setting->update(['value' => $path]);
                } else {
                    $setting->update(['value' => $value]);
                }
            }
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
