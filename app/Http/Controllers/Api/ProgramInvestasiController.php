<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramInvestasiRequest;
use App\Http\Resources\ProgramInvestasiResource;
use App\Http\Resources\ProgramInvestasiCollection;
use App\Models\ProgramInvestasi;
use App\Services\ProgramInvestasiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponse;

class ProgramInvestasiController extends Controller
{
    use ApiResponse;

    public function __construct(
        private ProgramInvestasiService $programService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $query = ProgramInvestasi::whereIn('status', ['ACTIVE', 'FUNDED', 'COMPLETED'])
                    ->with(['milestones', 'dokumens'])
                    ->withCount(['transaksiPendanaans as jumlah_investor' => function($q) {
                        $q->where('status_pembayaran', 'SUCCESS');
                    }]);
        
        // Menggunakan get_object_vars / response()->getData untuk menjaga format pagination
        $collection = new ProgramInvestasiCollection($query->paginate(10));
        return $this->successResponse($collection->response()->getData(true), 'Berhasil mengambil daftar program investasi');
    }

    public function indexKth(Request $request): JsonResponse
    {
        $userId = $request->user_id;
        $query = ProgramInvestasi::where('user_id', $userId)
                    ->with(['milestones', 'dokumens'])
                    ->withCount(['transaksiPendanaans as jumlah_investor' => function($q) {
                        $q->where('status_pembayaran', 'SUCCESS');
                    }]);
        
        $collection = new ProgramInvestasiCollection($query->paginate(10));
        return $this->successResponse($collection->response()->getData(true), 'Berhasil mengambil daftar program KTH');
    }

    public function show(string $id): JsonResponse
    {
        $program = ProgramInvestasi::with(['milestones', 'dokumens'])
                    ->withCount(['transaksiPendanaans as jumlah_investor' => function($q) {
                        $q->where('status_pembayaran', 'SUCCESS');
                    }])
                    ->findOrFail($id);
        return $this->successResponse(new ProgramInvestasiResource($program), 'Berhasil mengambil detail program');
    }

    public function store(StoreProgramInvestasiRequest $request): JsonResponse
    {
        try {
            $userId = $request->user_id;
            $program = $this->programService->createProgram($request->validated(), $userId);
            
            return $this->successResponse(new ProgramInvestasiResource($program), 'Program investasi berhasil diajukan.', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function indexAdmin(Request $request): JsonResponse
    {
        $query = ProgramInvestasi::with(['milestones', 'dokumens'])
                    ->withCount(['transaksiPendanaans as jumlah_investor' => function($q) {
                        $q->where('status_pembayaran', 'SUCCESS');
                    }]);
        
        $collection = new ProgramInvestasiCollection($query->paginate(10));
        return $this->successResponse($collection->response()->getData(true), 'Berhasil mengambil daftar semua program investasi untuk admin');
    }

    public function showAdmin(string $id): JsonResponse
    {
        $program = ProgramInvestasi::with(['milestones', 'dokumens', 'laporanProyeks', 'laporanKeuangans'])
                    ->withCount(['transaksiPendanaans as jumlah_investor' => function($q) {
                        $q->where('status_pembayaran', 'SUCCESS');
                    }])
                    ->findOrFail($id);
        return $this->successResponse(new ProgramInvestasiResource($program), 'Berhasil mengambil detail program admin');
    }
}
