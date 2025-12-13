<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TrService extends Model
{
    use HasFactory;

    protected $table = 'tr_services';

    protected $fillable = [
        'service_id',
        'user_id',
        'queue_number',
        'status',
        'queue_date',
        'estimated_time'
    ];

    // Relasi ke Service
    public function service()
    {
        return $this->belongsTo(MsService::class, 'service_id');
    }

    // Relasi ke User (Customer)
    public function user()
    {
        return $this->belongsTo(MsUser::class, 'user_id');
    }

    public function bookService(Request $request)
    {
        // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'service_id'     => 'required|exists:ms_services,id',
            'user_id'        => 'required|exists:ms_users,id',
            'queue_date'     => 'required|date_format:Y-m-d',
            'estimated_time' => 'nullable|date_format:H:i:s',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            // 2. Gunakan transaction untuk mencegah double queue_number
            $trService = DB::transaction(function () use ($request) {

                // Ambil nomor antrian terakhir (lock row)
                $lastQueue = TrService::where('service_id', $request->service_id)
                    ->where('queue_date', $request->queue_date)
                    ->lockForUpdate()
                    ->orderByDesc('queue_number')
                    ->first();

                $queueNumber = $lastQueue ? $lastQueue->queue_number + 1 : 1;

                // 3. Simpan booking
                return TrService::create([
                    'service_id'     => $request->service_id,
                    'user_id'        => $request->user_id,
                    'queue_number'   => $queueNumber,
                    'status'         => 'pending', // default status booking
                    'queue_date'     => $request->queue_date,
                    'estimated_time' => $request->estimated_time,
                ]);
            });

            return response()->json([
                'message' => 'Booking service berhasil',
                'data'    => $trService,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal melakukan booking service',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
