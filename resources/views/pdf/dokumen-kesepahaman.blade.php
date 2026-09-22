<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Kesepahaman PPDB 2026 - {{ $calon->nama_lengkap }}</title>
    <style>
        @page {
            margin: 20mm 18mm 20mm 18mm;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.45;
            color: #111;
        }
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
            margin-bottom: 18px;
        }
        .kop-table td {
            vertical-align: middle;
        }
        .kop-title {
            text-align: center;
        }
        .kop-title h1 {
            font-size: 15pt;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kop-title h2 {
            font-size: 12pt;
            margin: 3px 0 0 0;
            font-weight: normal;
        }
        .kop-title p {
            font-size: 8.5pt;
            margin: 3px 0 0 0;
            color: #444;
        }
        .doc-header {
            text-align: center;
            margin-bottom: 16px;
        }
        .doc-header h3 {
            font-size: 12pt;
            margin: 0;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .doc-header p {
            font-size: 9.5pt;
            margin: 3px 0 0 0;
            font-style: italic;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 10pt;
        }
        .info-table td {
            padding: 2.5px 4px;
            vertical-align: top;
        }
        .info-label {
            width: 28%;
            color: #222;
        }
        .info-colon {
            width: 2%;
            text-align: center;
        }
        .info-value {
            width: 70%;
            font-weight: 600;
        }
        .statements-list {
            margin: 10px 0 16px 0;
            padding-left: 22px;
            font-size: 10pt;
            text-align: justify;
        }
        .statements-list li {
            margin-bottom: 6px;
            line-height: 1.4;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 10pt;
        }
        .signature-table td {
            width: 50%;
            vertical-align: top;
            text-align: center;
        }
        .materai-box {
            display: inline-block;
            width: 100px;
            height: 52px;
            line-height: 52px;
            border: 1px dashed #666;
            background-color: #fafafa;
            color: #555;
            font-size: 8pt;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin: 10px 0;
        }
        .sign-space {
            height: 25px;
        }
        .sign-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- KOP SURAT RESMI -->
    <table class="kop-table">
        <tr>
            <td style="width: 15%; text-align: center;">
                <div style="width: 55px; height: 55px; background-color: #1e3a8a; color: #fff; font-weight: bold; font-size: 18pt; line-height: 55px; border-radius: 8px; margin: 0 auto;">
                    PPDB
                </div>
            </td>
            <td class="kop-title" style="width: 85%;">
                <h1>PANITIA PENERIMAAN PESERTA DIDIK BARU</h1>
                <h2>SMA / SMK TERPADU UNGGULAN 2026/2027</h2>
                <p>Jl. Pendidikan No. 45 Bandung &bull; Telp/WA: +62 812-3456-7890 &bull; Website: ppdb.sekolah-terpadu.sch.id</p>
            </td>
        </tr>
    </table>

    <!-- JUDUL DOKUMEN -->
    <div class="doc-header">
        <h3>SURAT KESEPAHAMAN & PERNYATAAN BERSAMA</h3>
        <p>Nomor Registrasi: REG/{{ date('Y') }}/{{ str_pad($calon->id, 5, '0', STR_PAD_LEFT) }}</p>
    </div>

    <p style="font-size: 10pt; margin-bottom: 8px;">Yang bertanda tangan di bawah ini:</p>

    <!-- DATA IDENTITAS CALON SISWA & ORANG TUA -->
    <table class="info-table">
        <tr>
            <td class="info-label">Nama Calon Siswa</td>
            <td class="info-colon">:</td>
            <td class="info-value">{{ $calon->nama_lengkap }}</td>
        </tr>
        <tr>
            <td class="info-label">NISN / NIK</td>
            <td class="info-colon">:</td>
            <td class="info-value">{{ $calon->nisn ?? '-' }} / {{ $calon->nik_siswa ?? '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Program Pilihan</td>
            <td class="info-colon">:</td>
            <td class="info-value">
                {{ $calon->program?->nama_program ?? 'Reguler' }}
                @if ($calon->jurusan)
                    - Peminatan: {{ $calon->jurusan->nama_jurusan }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="info-label">Asal Sekolah</td>
            <td class="info-colon">:</td>
            <td class="info-value">{{ $calon->asal_sekolah }}</td>
        </tr>
        <tr>
            <td class="info-label">Nama Orang Tua / Wali</td>
            <td class="info-colon">:</td>
            <td class="info-value">{{ $calon->nama_ayah ?: ($calon->nama_ibu ?: 'Orang Tua Calon Siswa') }}</td>
        </tr>
        <tr>
            <td class="info-label">No. Telepon / WhatsApp</td>
            <td class="info-colon">:</td>
            <td class="info-value">{{ $calon->hp_siswa ?? $calon->hp_ayah }}</td>
        </tr>
        <tr>
            <td class="info-label">Alamat Domisili</td>
            <td class="info-colon">:</td>
            <td class="info-value">{{ $calon->alamat_detail ?? 'Sesuai Kartu Keluarga (KK)' }}</td>
        </tr>
    </table>

    <p style="font-size: 10pt; margin-top: 10px; margin-bottom: 6px;">
        Menyatakan dengan sesungguhnya memahami, menyepakati, dan berkomitmen penuh terhadap butir-butir kesepahaman penerimaan peserta didik baru Program <strong>{{ $calon->program?->nama_program ?? 'Reguler' }}</strong> sebagai berikut:
    </p>

    <!-- BUTIR PERNYATAAN KESEPAHAMAN DARI BASIS DATA STATIS -->
    <ol class="statements-list">
        @forelse ($butirKesepahaman as $item)
            <li>{{ $item->butir_pernyataan }}</li>
        @empty
            <li>Sanggup menaati seluruh tata tertib dan peraturan akademik madrasah/sekolah selama menjadi peserta didik aktif.</li>
            <li>Bersedia mengikuti seluruh program kurikulum, pembinaan karakter, dan kegiatan keagamaan yang ditetapkan oleh pihak sekolah.</li>
            <li>Bersedia menyelesaikan seluruh kewajiban administrasi daftar ulang dan keuangan sekolah tepat waktu sesuai ketentuan.</li>
        @endforelse
    </ol>

    <p style="font-size: 9.5pt; text-align: justify; margin-top: 8px;">
        Demikian surat kesepahaman dan pernyataan ini kami buat dengan penuh kesadaran dan tanggung jawab tanpa paksaan dari pihak manapun untuk dipergunakan sebagaimana mestinya.
    </p>

    <!-- TANDA TANGAN DENGAN KOTAK MATERAI 10000 -->
    <table class="signature-table">
        <tr>
            <td></td>
            <td style="padding-bottom: 8px;">Bandung, {{ now()->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>
                <strong>Orang Tua / Wali Siswa,</strong>
                <div class="sign-space"></div>
                <div style="height: 52px;"></div>
                <div class="sign-name">( {{ $calon->nama_ayah ?: ($calon->nama_ibu ?: '..................................................') }} )</div>
                <div style="font-size: 8.5pt; color: #555;">Tanda Tangan & Nama Terang</div>
            </td>
            <td>
                <strong>Calon Peserta Didik,</strong>
                <div>
                    <!-- KOTAK TEMPAT MATERAI 10000 -->
                    <div class="materai-box">
                        Materai 10000
                    </div>
                </div>
                <div class="sign-name">( {{ $calon->nama_lengkap }} )</div>
                <div style="font-size: 8.5pt; color: #555;">Tanda Tangan Siswa</div>
            </td>
        </tr>
    </table>
</body>
</html>
