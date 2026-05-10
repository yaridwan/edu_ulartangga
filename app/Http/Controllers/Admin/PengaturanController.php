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
        $settings = PengaturanAplikasi::all();

        foreach ($settings as $setting) {
            $key = $setting->key;

            if ($setting->type === 'image') {
                // Only process if a new file was uploaded
                if ($request->hasFile($key)) {
                    // Delete old file if exists
                    if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                        Storage::disk('public')->delete($setting->value);
                    }
                    $path = $request->file($key)->store('pengaturan', 'public');
                    $setting->update(['value' => $path]);
                }
            } else {
                // For non-image settings, update the value if present in request
                if ($request->has($key)) {
                    $setting->update(['value' => $request->input($key)]);
                }
            }
        }

        // Ensure storage link exists
        if (!file_exists(public_path('storage'))) {
            try {
                \Artisan::call('storage:link');
            } catch (\Exception $e) {
                // On Windows, symlink may require admin - copy files instead
                $this->createStorageFallback();
            }
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    /**
     * Fallback: copy storage files to public when symlink fails (Windows without admin)
     */
    private function createStorageFallback()
    {
        $source = storage_path('app/public');
        $destination = public_path('storage');

        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        // Copy pengaturan directory
        $pengaturanSource = $source . DIRECTORY_SEPARATOR . 'pengaturan';
        $pengaturanDest = $destination . DIRECTORY_SEPARATOR . 'pengaturan';

        if (is_dir($pengaturanSource)) {
            if (!is_dir($pengaturanDest)) {
                mkdir($pengaturanDest, 0755, true);
            }

            foreach (scandir($pengaturanSource) as $file) {
                if ($file !== '.' && $file !== '..') {
                    copy($pengaturanSource . DIRECTORY_SEPARATOR . $file, $pengaturanDest . DIRECTORY_SEPARATOR . $file);
                }
            }
        }
    }
}
