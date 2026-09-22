<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Registrasi PPDB</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; line-height: 1.5; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2, .header h3 { margin: 0; padding: 0; }
        .header h3 { color: #555; }
        .content { margin-bottom: 30px; }
        .table-info { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table-info th, .table-info td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        .table-info th { width: 35%; background-color: #f9f9f9; }
        .credentials { background-color: #f0f8ff; padding: 15px; border: 1px dashed #0056b3; margin-top: 20px; }
        .credentials h3 { margin-top: 0; color: #0056b3; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 40px; border-top: 1px solid #eee; padding-top: 10px; }
        .text-center { text-align: center; }
        .barcode-box { margin-top: 20px; text-align: center; border: 1px solid #000; display: inline-block; padding: 10px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>PANITIA PENERIMAAN PESERTA DIDIK BARU (PPDB)</h2>
        <h3>SMK WIKRAMA 1 GARUT TA 2026/2027</h3>
        <p>Jl. Otista Kp Tanjung, Tarogong Kaler, Garut 44151 | Telp: 628112232880</p>
    </div>

    <div class="content">
        <h3 class="text-center">TANDA BUKTI REGISTRASI AWAL</h3>
        
        <p>Selamat! Anda telah berhasil melakukan registrasi awal pada sistem PPDB SMK Wikrama 1 Garut. Berikut adalah rincian data Anda:</p>

        <table class="table-info">
            <tr>
                <th>Nomor Pendaftar</th>
                <td style="font-weight: bold; font-size: 16px;">{{ $calonSiswa->nomor_pendaftar }}</td>
            </tr>
            <tr>
                <th>NISN</th>
                <td>{{ $calonSiswa->nisn }}</td>
            </tr>
            <tr>
                <th>Nama Lengkap</th>
                <td>{{ $calonSiswa->nama_lengkap }}</td>
            </tr>
            <tr>
                <th>Asal Sekolah</th>
                <td>{{ $calonSiswa->asal_sekolah }}</td>
            </tr>
            <tr>
                <th>Program Dipilih</th>
                <td>{{ $calonSiswa->program->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Registrasi</th>
                <td>{{ $calonSiswa->created_at->format('d F Y H:i:s') }}</td>
            </tr>
        </table>

        <div class="credentials">
            <h3>KREDENSIAL LOGIN AKUN</h3>
            <p>Gunakan informasi di bawah ini untuk masuk (login) ke dalam sistem dan melanjutkan tahapan pendaftaran selanjutnya.</p>
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="width: 30%;"><strong>Username (Email)</strong></td>
                    <td>: {{ $calonSiswa->user->email }}</td>
                </tr>
                <tr>
                    <td><strong>Password</strong></td>
                    <td>: {{ $calonSiswa->nisn }}</td>
                </tr>
            </table>
        </div>

        <p style="margin-top: 20px; font-weight: bold; color: red;">
            PERHATIAN:<br>
            Harap simpan dokumen ini dengan baik. Langkah selanjutnya adalah melakukan login ke portal PPDB dan mengunggah Bukti Pembayaran Biaya Seleksi.
        </p>

    </div>

    <div class="footer">
        Dicetak dari Sistem PPDB Digital SMK Wikrama 1 Garut pada {{ date('d-m-Y H:i') }}
    </div>
</div>

</body>
</html>
