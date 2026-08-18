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

class ProgramInvestasiController extends Controller
{
    public function __construct(
        private ProgramInvestasiService $programService
    ) {}

    public function index(Request $request)
    {
        // Publik/Investor: Hanya tampilkan yang ACTIVE atau FUNDED
        $query = ProgramInvestasi::whereIn('status', ['ACTIVE', 'FUNDED', 'COMPLETED'])
                    ->with(['milestones', 'dokumens']);
        
        return new ProgramInvestasiCollection($query->paginate(10));
    }

    public function indexKth(Request $request)
    {
        // KTH: Tampilkan semua program milik user tersebut
        $userId = $request->user_id; // Dari middleware / token
        $query = ProgramInvestasi::where('user_id', $userId)
                    ->with(['milestones', 'dokumens']);
        
        return new ProgramInvestasiCollection($query->paginate(10));
    }

    public function show(string $id)
    {
        $program = ProgramInvestasi::with(['milestones', 'dokumens'])->findOrFail($id);
        return new ProgramInvestasiResource($program);
    }

    public function store(StoreProgramInvestasiRequest $request): JsonResponse
    {
        try {
            $userId = $request->user_id; // Dari middleware / token
            $program = $this->programService->createProgram($request->validated(), $userId);
            
            return response()->json([
                'message' => 'Program investasi berhasil diajukan.',
                'data' => new ProgramInvestasiResource($program)
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
