<?php

namespace App\Services;

use App\Models\TransaksiPendanaan;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

class PersetujuanInvestorService
{
    /**
     * Get list of pending investment applications for a specific KTH
     */
    public function getListPengajuan(string $kthId, array $filters = []): LengthAwarePaginator
    {
        $query = TransaksiPendanaan::with(['program'])
            ->whereHas('program', function ($q) use ($kthId) {
                $q->where('user_id', $kthId);
            })
            ->orderBy('created_at', 'desc');

        if (isset($filters['status_persetujuan'])) {
            $query->where('status_persetujuan', $filters['status_persetujuan']);
        }

        return $query->paginate($filters['per_page'] ?? 10);
    }

    /**
     * Get details of a specific investment application
     */
    public function getDetailPengajuan(string $id, string $kthId): TransaksiPendanaan
    {
        $transaksi = TransaksiPendanaan::with(['program.dokumens'])
            ->whereHas('program', function ($q) use ($kthId) {
                $q->where('user_id', $kthId);
            })
            ->findOrFail($id);

        return $transaksi;
    }

    /**
     * Update the approval status
     */
    public function updateStatus(string $id, string $status, string $kthId): TransaksiPendanaan
    {
        if (!in_array($status, ['DITERIMA', 'DITOLAK', 'MENUNGGU_REVISI'])) {
            throw new Exception("Status persetujuan tidak valid.");
        }

        $transaksi = $this->getDetailPengajuan($id, $kthId);

        if ($transaksi->status_persetujuan !== 'MENUNGGU' && $transaksi->status_persetujuan !== 'MENUNGGU_REVISI') {
            throw new Exception("Pengajuan ini sudah " . strtolower($transaksi->status_persetujuan) . ".");
        }

        $transaksi->update([
            'status_persetujuan' => $status
        ]);

        return $transaksi;
    }
}
