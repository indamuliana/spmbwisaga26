<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CetakAkunController extends Controller
{
    public function cetak($id)
    {
        $calonSiswa = CalonSiswa::with('user')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.cetak-akun', compact('calonSiswa'));

        // Return inline stream PDF
        return $pdf->stream('Bukti-Registrasi-' . $calonSiswa->nomor_pendaftar . '.pdf');
    }
}
