<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MsUser;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function login(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'min:6'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        }

        // Cek kredensial
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email atau Password Anda salah',
            ], 401);
        }

        // Ambil user
        $user = MsUser::where('email', $request->email)->first();

        // Generate token Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function register(Request $request)
    {
        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:msuser,email'],
                'password' => ['required', 'string', 'min:6'],
                'roleId' => ['required', 'integer'],
            ]);


            $user = MsUser::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'roleId' => $request->roleId,
            ]);


            $token = $user->createToken("api-token")->plainTextToken;

            return response()->json([
                'message'   => 'Registrasi berhasil',
                'user'      => $user,
                'token'     => $token
            ], 201);

        } catch (ValidationException $e) {

            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Terjadi kesalahan server',
                'error'   => $e->getMessage(),  
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logout berhasil'
            ], 200);
        }

        return response()->json([
            'message' => 'User tidak ditemukan'
        ], 404);
    }

    public function getPermissions(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $role = $user->role;
        $permissions = $role ? $role->permissions()->pluck('slug') : [];

        return response()->json([
            'role' => $role?->name,
            'permissions' => $permissions
        ]);
    }

    public function getAllUser(Request $request)
    {
        $page = $request->query('page', 1);
        $limit = $request->query('pageSize', 10);  

        $query = MsUser::with('role');

        $filters = $request->query('filters', []); 

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        $paginated = $query->paginate($limit, ['*'], 'page', $page);  

        // Tambahkan roleName langsung
        $paginated->getCollection()->transform(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roleId' => $user->roleId,
                'roleName' => $user->role?->name,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];
        });

        return response()->json($paginated);
    }

    public function getUserById($id)
    {
        $user = MsUser::with('role')->find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roleId' => $user->roleId,
            'roleName' => $user->role?->name, 
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ], 200);
    }

    public function deleteUser($id)
    {
        try {
            
            $user = MsUser::findOrFail($id);

            $user->delete();

            return response()->json([
                'message' => 'User berhasil dihapus',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function updateUser(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'roleId' => 'required|integer',
            ]);

            $user = MsUser::findOrFail($id);

            $user->name = $request->name;
            $user->roleId = $request->roleId;

            $user->save();

            return response()->json([
                'message' => 'User berhasil diperbarui',
                'user' => $user,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function storeUser(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:msuser,email',
                'roleId' => 'required|integer',
            ]);

            $defaultPassword = 'Password123';

            $user = new MsUser();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->roleId = $request->roleId;
            $user->password = Hash::make($defaultPassword);  

            $user->save();

            return response()->json([
                'message' => 'User berhasil disimpan',
                'data' => $user,
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }







}
