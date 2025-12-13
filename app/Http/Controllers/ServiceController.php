<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsService;
use App\Models\TrService;
use App\Models\MsUser;
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
                'code' => $service->code,
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
            'code' => 'required|string',
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
            'code' => $request->code,
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
            'code' => 'required|string',
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
            'code' => $request->code ?? null,
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

   public function createQueue(Request $request)
{
    $validator = Validator::make($request->all(), [
        'service_id' => 'required|exists:ms_services,id',
        'user_id'    => 'required|exists:msuser,id',
        'queue_date' => 'required|date_format:Y-m-d',
        'estimated_time' => 'nullable|date_format:H:i:s',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors' => $validator->errors()
        ], 422);
    }

    $service = MsService::findOrFail($request->service_id);
    $serviceCode = strtoupper($service->code);

    /**
     * 🔹 Ambil antrian AKTIF (group by service & tanggal)
     */
    $activeQueue = TrService::where('service_id', $service->id)
        ->where('queue_date', $request->queue_date)
        ->whereIn('status', ['waiting', 'processing'])
        ->orderBy('queue_number', 'asc')
        ->first();

    /**
     * 🔹 Tentukan status awal
     * - Jika belum ada antrian → processing
     * - Jika sudah ada → waiting
     */
    $initialStatus = $activeQueue ? 'waiting' : 'processing';

    /**
     * 🔹 Ambil nomor antrian terakhir
     */
    $lastQueue = TrService::where('service_id', $service->id)
        ->where('queue_date', $request->queue_date)
        ->orderByDesc('queue_number')
        ->first();

    $queueNumber = $lastQueue ? intval($lastQueue->queue_number) + 1 : 1;

    /**
     * 🔹 Simpan antrian
     */
    $trService = TrService::create([
        'service_id'     => $service->id,
        'user_id'        => $request->user_id,
        'queue_number'   => $queueNumber,
        'status'         => $initialStatus,
        'queue_date'     => $request->queue_date,
        'estimated_time' => $request->estimated_time ?? null,
    ]);

    return response()->json([
        'message' => 'Antrian berhasil dibuat',
        'data' => [
            'id' => $trService->id,
            'service_id' => $service->id,
            'queue_number' => $queueNumber,
            'queue_code' => $serviceCode . $queueNumber,
            'status' => $initialStatus,
            'queue_date' => $trService->queue_date,
        ]
    ], 201);
}





    public function getServiceStaff($id)
    {
        $service = MsService::findOrFail($id);
        $staff = MsUser::whereIn('id', $service->assigned_user_ids ?? [])->get();

        return response()->json([
            'service' => $service,
            'staff' => $staff
        ]);
    }

    public function getActiveQueue($userId)
{
    $queue = TrService::with('service')
        ->where('user_id', $userId)
        ->whereIn('status', ['waiting', 'processing'])
        ->orderBy('queue_date', 'asc')
        ->orderBy('queue_number', 'asc')
        ->first();

    if (!$queue) {
        return response()->json([
            'message' => 'Tidak ada antrian aktif',
            'data' => null
        ], 200);
    }

    $service = $queue->service;

    /**
     * 🔹 Antrian yang sedang dilayani (processing)
     */
    $currentProcessing = TrService::where('service_id', $service->id)
        ->where('queue_date', $queue->queue_date)
        ->where('status', 'processing')
        ->orderBy('queue_number', 'asc')
        ->first();

    /**
     * 🔹 Hitung jumlah antrian sebelum user
     */
    $queuesBefore = TrService::where('service_id', $service->id)
        ->where('queue_date', $queue->queue_date)
        ->where('queue_number', '<', $queue->queue_number)
        ->whereIn('status', ['waiting', 'processing'])
        ->count();

    /**
     * 🔹 Estimasi waktu per service (menit)
     */
    $serviceEstimatedMinutes = 0;
    if ($service->estimated_time) {
        [$h, $m, $s] = explode(':', $service->estimated_time);
        $serviceEstimatedMinutes = ($h * 60) + $m;
    }

    $totalEstimatedMinutes = $queuesBefore * $serviceEstimatedMinutes;

    return response()->json([
        'message' => 'Antrian aktif ditemukan',
        'data' => [
            'service_name' => $service->name,

            // antrian user
            'your_queue' => [
                'queue_code' => strtoupper($service->code) . $queue->queue_number,
                'status' => $queue->status,
            ],

            // antrian yang sedang dilayani
            'current_serving' => $currentProcessing
                ? strtoupper($service->code) . $currentProcessing->queue_number
                : null,

            'estimated_waiting_time' => $totalEstimatedMinutes, // menit
        ]
    ], 200);
}


    







}
