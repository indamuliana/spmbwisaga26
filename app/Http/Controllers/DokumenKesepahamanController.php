<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\DokumenKesepahaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokumenKesepahamanController extends Controller
{
    /**
     * Cetak dokumen kesepahaman program PPDB dalam format PDF.
     * Mengambil data butir pernyataan dari tabel dokumen_kesepahaman sesuai program siswa.
     */
    public function cetakPdf(Request $request, ?int $calonSiswaId = null)
    {
        $user = Auth::user();

        if ($user && $user->isSiswa()) {
            $calon = $user->calonSiswa;
        } else {
            $calon = $calonSiswaId
                ? CalonSiswa::findOrFail($calonSiswaId)
                : ($user?->calonSiswa ?: CalonSiswa::first());
        }

        if (! $calon) {
            abort(404, 'Data pendaftaran calon siswa tidak ditemukan.');
        }

        // Ambil butir kesepahaman sesuai program pilihan siswa (dan butir universal)
        $butirKesepahaman = DokumenKesepahaman::forProgram($calon->program_id)
            ->active()
            ->orderBy('urutan', 'asc')
            ->get();

        $pdf = Pdf::loadView('pdf.dokumen-kesepahaman', [
            'calon' => $calon,
            'butirKesepahaman' => $butirKesepahaman,
        ])->setPaper('a4', 'portrait');

        $filename = 'Surat_Kesepahaman_' . ($calon->nisn ?: $calon->id) . '.pdf';

        if ($request->boolean('download')) {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }
}
