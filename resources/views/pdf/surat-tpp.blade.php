<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Bukti Persetujuan TPP</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        .header h3,
        .header p {
            margin: 0;
        }

        .content {
            margin-top: 30px;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td {
            padding: 8px;
        }

        .label {
            width: 30%;
            font-weight: bold;
        }

        .signature {
            margin-top: 60px;
            text-align: right;
            width: 100%;
        }

        .signature .name {
            margin-top: 70px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h3>PEMERINTAH KOTA BENGKULU</h3>
            <h2>BADAN KEPEGAWAIAN DAN PENGEMBANGAN SDM</h2>
            <p>Alamat: Jl. WR Supratman No.12, Bentiring, Kota Bengkulu</p>
        </div>

        <div class="content">
            <div class="title">BUKTI PERSETUJUAN PENGAJUAN TPP</div>

            <p>Dengan ini menerangkan bahwa pengajuan Tambahan Penghasilan Pegawai (TPP) untuk rincian di bawah ini
                telah diverifikasi dan disetujui:</p>

            <table>
                <tr>
                    <td class="label">Unit Kerja (OPD)</td>
                    <td>: {{ $pengajuan->opd->nama_opd }}</td>
                </tr>
                <tr>
                    <td class="label">Periode</td>
                    <td>: {{ $namaBulan }} {{ $pengajuan->periode_tahun }}</td>
                </tr>
                <tr>
                    <td class="label">Total Besaran Diajukan</td>
                    <td>: Rp {{ number_format($pengajuan->besaran_tpp_diajukan, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Disetujui</td>
                    <td>: {{ $pengajuan->updated_at->translatedFormat('d F Y') }}</td>
                </tr>
            </table>

            <p style="margin-top: 20px;">Dokumen ini merupakan bukti yang sah dan dapat digunakan sebagaimana mestinya.
            </p>

            <div class="signature">
                <div>Bengkulu, {{ now()->translatedFormat('d F Y') }}</div>
                <div>Kepala Badan Kepegawaian dan <br>Pengembangan Sumber Daya Manusia,</div>
                <div class="name">
                    {{-- ========================================================== --}}
                    {{-- BAGIAN YANG DISESUAIKAN: Tanda Tangan Dinamis --}}
                    {{-- ========================================================== --}}
                    @if ($kepalaBkpsdm)
                        <strong>{{ $kepalaBkpsdm->name }}</strong><br>
                        NIP. {{ $kepalaBkpsdm->nip }}
                    @else
                        <strong>(Kepala OPD Tidak Ditemukan)</strong><br>
                        (NIP. ......................)
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

</html>
