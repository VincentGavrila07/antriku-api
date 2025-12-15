<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function getAllBerita()
    {
        try {
            $berita = Berita::orderBy('published_at', 'desc')->get();

            return response()->json([
                'data' => $berita,
                'message' => 'Berita fetched successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeBerita(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'published_at' => 'nullable|date',
            ]);

            $berita = new Berita();
            $berita->judul = $request->judul;
            $berita->deskripsi = $request->deskripsi;
            $berita->published_at = $request->published_at;

            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('berita', 'public');
                $berita->foto = asset('storage/' . $path);
            }

            $berita->save();

            return response()->json([
                'message' => 'Berita berhasil disimpan',
                'data' => $berita,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function updateBerita(Request $request, $id)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'published_at' => 'nullable|date',
            ]);

            $berita = Berita::findOrFail($id);

            $berita->judul = $request->judul;
            $berita->deskripsi = $request->deskripsi;
            $berita->published_at = $request->published_at;

            if ($request->hasFile('foto')) {
                if ($berita->foto) {
                    $oldPath = str_replace(asset('storage') . '/', '', $berita->foto);
                    Storage::disk('public')->delete($oldPath);
                }

                $path = $request->file('foto')->store('berita', 'public');
                $berita->foto = asset('storage/' . $path);
            }

            $berita->save();

            return response()->json([
                'message' => 'Berita berhasil diperbarui',
                'data' => $berita,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function deleteBerita($id)
    {
        try {
            $berita = Berita::findOrFail($id);
            $berita->delete();

            return response()->json([
                'message' => 'Berita berhasil dihapus',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getDetailBerita($id)
    {
        try {
            $berita = Berita::findOrFail($id);

            return response()->json([
                'data' => $berita,
                'message' => 'Detail berita fetched successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Berita tidak ditemukan',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

}
