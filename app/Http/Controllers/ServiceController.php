<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsService;
use App\Models\TrService;
use App\Models\MsUser;
use App\Models\ServiceReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf; 

class ServiceController extends Controller
{
    public function getAllServices(Request $request)
    {
        $page  = $request->query('page', 1);
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
                'estimated_time' => $service->estimated_time,
                'is_active' => $service->is_active,
                'assigned_user_ids' => $service->assigned_user_ids ?? [],
                'assigned_users' => $service->getAssignedUsers(), // 🔥 INI KUNCINYA
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

        /**
         * 🔴 Cek antrian aktif milik user
         */
        $existingQueue = TrService::where('user_id', $request->user_id)
            ->where('queue_date', $request->queue_date)
            ->whereIn('status', ['waiting', 'processing'])
            ->first();

        if ($existingQueue) {
            return response()->json([
                'message' => 'Anda masih memiliki antrian yang sedang aktif',
                'data' => [
                    'queue_id' => $existingQueue->id,
                    'queue_number' => $existingQueue->queue_number,
                    'status' => $existingQueue->status,
                    'queue_date' => $existingQueue->queue_date,
                ]
            ], 409);
        }

        $service = MsService::findOrFail($request->service_id);
        $serviceCode = strtoupper($service->code);

        /**
         * 🔹 Ambil antrian aktif per service
         */
        $activeQueue = TrService::where('service_id', $service->id)
            ->where('queue_date', $request->queue_date)
            ->whereIn('status', ['waiting', 'processing'])
            ->orderBy('queue_number', 'asc')
            ->first();

        /**
         * 🔹 Tentukan status awal
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

    public function getAllQueueByService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:ms_services,id',
            'queue_date' => 'nullable|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $service = MsService::findOrFail($request->service_id);
        $queueDate = $request->queue_date ?? now()->format('Y-m-d');

        /**
         * 🔹 Ambil semua queue by service & tanggal
         */
        $queues = TrService::with('user')
            ->where('service_id', $service->id)
            ->where('queue_date', $queueDate)
            ->orderByRaw("
                CASE status
                    WHEN 'processing' THEN 1
                    WHEN 'waiting' THEN 2
                    WHEN 'done' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('queue_number', 'asc')
            ->get();

        /**
         * 🔹 Mapping response
         */
        $data = $queues->map(function ($queue) use ($service) {
            return [
                'id' => $queue->id,
                'queue_code' => strtoupper($service->code) . $queue->queue_number,
                'queue_number' => $queue->queue_number,
                'status' => $queue->status,
                'user' => $queue->user ? [
                    'id' => $queue->user->id,
                    'name' => $queue->user->name,
                ] : null,
                'queue_date' => $queue->queue_date,
                'estimated_time' => $queue->estimated_time,
            ];
        });

        return response()->json([
            'message' => 'Daftar antrian berhasil diambil',
            'service' => [
                'id' => $service->id,
                'name' => $service->name,
                'code' => $service->code,
            ],
            'total_queue' => $data->count(),
            'data' => $data
        ], 200);
    }

    
    public function getMyService(Request $request)
    {
        $user_id = $request->user_id;

        $services = MsService::whereJsonContains('assigned_user_ids', (int) $user_id)
            ->where('is_active', true)
            ->get()
            ->map(function ($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'code' => $service->code,
                    'description' => $service->description,
                    'estimated_time' => $service->estimated_time,
                ];
            });

        return response()->json([
            'message' => 'Service milik user berhasil diambil',
            'total' => $services->count(),
            'data' => $services
        ], 200);
    }

    public function updateStatusQueue(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'queue_id' => 'required|exists:tr_services,id',
            'status'   => 'required|in:waiting,processing,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $queue = TrService::findOrFail($request->queue_id);

        // Update status
        $queue->status = $request->status;
        $queue->save();

        return response()->json([
            'message' => 'Status antrian berhasil diperbarui',
            'data' => [
                'id' => $queue->id,
                'service_id' => $queue->service_id,
                'queue_number' => $queue->queue_number,
                'status' => $queue->status,
                'queue_date' => $queue->queue_date,
            ]
        ], 200);
    }



    public function getTotalServe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'nullable|exists:ms_services,id', 
            'queue_date' => 'nullable|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $queueDate = $request->queue_date ?? now()->format('Y-m-d');
        $serviceId = $request->service_id;

        $query = TrService::where('status', 'completed')
                          ->where('queue_date', $queueDate);

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        $totalCompleted = $query->count();

        $serviceName = $serviceId ? MsService::find($serviceId)->name : 'Semua Layanan';

        return response()->json([
            'message' => 'Total layanan yang diselesaikan berhasil diambil',
            'date' => $queueDate,
            'service' => $serviceName,
            'total_completed_services' => $totalCompleted,
        ], 200);
    }

    public function getHistoryByService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:ms_services,id',
            'queue_date' => 'nullable|date_format:Y-m-d',
            'status' => 'nullable|in:waiting,processing,completed,cancelled',
            'page' => 'nullable|integer',
            'pageSize' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $serviceId = $request->service_id;
        $queueDate = $request->queue_date;
        $status = $request->status;

        $page = $request->query('page', 1);
        $limit = $request->query('pageSize', 10); 

        // 1. Ambil model layanan untuk detail dan kode
        $service = MsService::findOrFail($serviceId);

        // 2. Query ke TrService
        $query = TrService::with('user')
            ->where('service_id', $serviceId);
        
        // Filter opsional: Tanggal
        if ($queueDate) {
            $query->whereDate('queue_date', $queueDate);
        }
        
        // Filter opsional: Status
        if ($status) {
            $query->where('status', $status);
        }
        
        // Urutkan dari yang terbaru (tanggal dan waktu dibuat)
        $query->orderBy('queue_date', 'desc')
              ->orderBy('created_at', 'desc');

        // 3. Lakukan Pagination
        $paginated = $query->paginate($limit, ['*'], 'page', $page); 
        $data = $paginated->getCollection()->map(function ($queue) use ($service) {
            return [
                'queue_id' => $queue->id,
                'queue_code' => strtoupper($service->code) . $queue->queue_number,
                'queue_number' => $queue->queue_number,
                'status' => $queue->status,
                'queue_date' => $queue->queue_date,
                'initial_complaint' => $queue->initial_complaint,
                'user' => $queue->user ? [
                    'id' => $queue->user->id,
                    'name' => $queue->user->name,
                ] : null,
                'created_at' => $queue->created_at,
                'updated_at' => $queue->updated_at,
            ];
        });

        return response()->json([
            'message' => 'Riwayat antrian berdasarkan layanan berhasil diambil',
            'service_name' => $service->name,
            'current_page' => $paginated->currentPage(),
            'data' => $data,
            'last_page' => $paginated->lastPage(),
            'total' => $paginated->total(),
        ], 200);
    }

   public function getServiceHistory(Request $request, $roleId)
    {
        $page  = $request->query('page', 1);
        $limit = $request->query('pageSize', 10);

        $query = TrService::with(['service', 'user']);

        // Jika role customer / 2, filter by user_id dari request FE
        if ((int) $roleId === 2 && $request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('queue_date')) {
            $query->whereDate('queue_date', $request->queue_date);
        }

        $paginated = $query
            ->orderByDesc('created_at')
            ->paginate($limit, ['*'], 'page', $page);

        $paginated->getCollection()->transform(function ($item) {
            return [
                'id'           => $item->id,
                'queue_code'   => ($item->service?->code ?? '') . $item->queue_number,
                'queue_number' => $item->queue_number,
                'status'       => $item->status,
                'queue_date'   => $item->queue_date,
                'service' => [
                    'id'   => $item->service?->id,
                    'name' => $item->service?->name,
                ],
                'user' => [
                    'id'   => $item->user?->id,
                    'name' => $item->user?->name,
                ],
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        return response()->json([
            'message'      => 'Riwayat layanan berhasil diambil',
            'current_page' => $paginated->currentPage(),
            'last_page'    => $paginated->lastPage(),
            'per_page'     => $paginated->perPage(),
            'total'        => $paginated->total(),
            'data'         => $paginated->items(),
        ]);
    }



    public function generateReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_date' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $reportDate = $request->report_date;

        // Ambil semua transaksi service pada tanggal tersebut
        $transactions = TrService::with(['service', 'user'])
            ->whereDate('queue_date', $reportDate)
            ->orderBy('queue_number', 'asc')
            ->get();

        // Render view PDF (buat blade: resources/views/reports/service_report.blade.php)
        $pdf = PDF::loadView('service_report', [
            'transactions' => $transactions,
            'report_date' => $reportDate,
        ]);

        // Simpan PDF ke storage
        $fileName = "service_report_{$reportDate}.pdf";
        $filePath = storage_path("app/public/reports/{$fileName}");
        $pdf->save($filePath);

        // Simpan record report ke DB
        $report = ServiceReport::create([
            'report_date' => $reportDate,
            'created_by'  => $request->user_id, 
            'file_path'   => "reports/{$fileName}",
        ]);

        return response()->json([
            'message' => 'Report berhasil dibuat',
            'report' => $report,
            'file_url' => url("storage/{$report->file_path}"),
        ]);
    }

    public function downloadReport($fileName)
    {
        $filePath = storage_path("app/public/reports/{$fileName}");

        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }

        return response()->download($filePath);
    }

}
