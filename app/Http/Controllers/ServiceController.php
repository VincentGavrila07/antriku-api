<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsService;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function getAllServices(Request $request)
    {
        $page = $request->query('page', 1);
        $limit = $request->query('pageSize', 10);  

        $query = MsService::query();

        $filters = $request->query('filters', []); 
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        $paginated = $query->paginate($limit, ['*'], 'page', $page);  

        $paginated->getCollection()->transform(function ($service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'description' => $service->description,
                'created_at' => $service->created_at,
                'updated_at' => $service->updated_at,
            ];
        });

        return response()->json($paginated);
    }


    // Menambahkan service baru
    public function storeService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:ms_services,name', 
            'description' => 'nullable|string',
            'assigned_user_ids' => 'nullable|array',
            'assigned_user_ids.*' => 'integer',
            'is_active' => 'nullable|boolean',
            'estimated_time' => 'nullable|date_format:H:i:s',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $service = MsService::create([
            'name' => $request->name,
            'description' => $request->description ?? null,
            'assigned_user_ids' => $request->assigned_user_ids ?? null,
            'is_active' => $request->is_active ?? true,
            'estimated_time' => $request->estimated_time ?? null,
        ]);

        return response()->json([
            'message' => 'Service berhasil dibuat',
            'data' => $service
        ], 201);
    }

    public function deleteService($id)
    {
        try {
            
            $service = MsService::findOrFail($id);

            $service->delete();

            return response()->json([
                'message' => 'Service berhasil dihapus',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus Service',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateService(Request $request, $id)
    {
        // Cari service
        $service = MsService::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:ms_services,name,' . $id,
            'description' => 'nullable|string',
            'assigned_user_ids' => 'nullable|array',
            'assigned_user_ids.*' => 'integer',
            'is_active' => 'nullable|boolean',
            'estimated_time' => 'nullable|date_format:H:i:s',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update service
        $service->update([
            'name' => $request->name,
            'description' => $request->description ?? null,
            'assigned_user_ids' => $request->assigned_user_ids ?? null,
            'is_active' => $request->is_active ?? true,
            'estimated_time' => $request->estimated_time ?? null,
        ]);

        return response()->json([
            'message' => 'Service berhasil diperbarui',
            'data' => $service
        ], 200);
    }

    public function getServiceById($id)
    {
        try {
            $service = MsService::findOrFail($id);

            return response()->json([
                'message' => 'Service berhasil ditemukan',
                'data' => $service
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Service tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }


}
