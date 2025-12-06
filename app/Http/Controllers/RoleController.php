<?php

namespace App\Http\Controllers;

use App\Models\MsRole;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function getAllRole(Request $request)
    {
        try {
            $roles = MsRole::with('user', 'permissions')->get();

            return response()->json([
                'data' => $roles,
                'message' => 'Roles fetched successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching roles.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteRole($id)
    {
        try {
            
            $role = MsRole::findOrFail($id);

            $role->delete();

            return response()->json([
                'message' => 'Role berhasil dihapus',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus role',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeRole(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $role = new MsRole();
            $role->name = $request->name;

            $role->save();

            return response()->json([
                'message' => 'Role berhasil disimpan',
                'data' => $role,
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data role',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateRole(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $role = MsRole::findOrFail($id);

            $role->name = $request->name;

            $role->save();

            return response()->json([
                'message' => 'Role berhasil diperbarui',
                'user' => $role,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui role',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getRoleById($id)
    {
        $role = MsRole::find($id);

        if (!$role) {
            return response()->json([
                'message' => 'role tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'id' => $role->id,
            'name' => $role->name,
        ], 200);
    }
}
