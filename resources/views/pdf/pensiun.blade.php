<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pegawai Akan Pensiun</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 10px;
        }

        h3,
        h4 {
            text-align: center;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h3>DAFTAR PEGAWAI NEGERI SIPIL YANG AKAN PENSIUN</h3>
    <h4>(DALAM {{ $rentangTahun }} TAHUN KE DEPAN)</h4>
    <h4>PEMERINTAH KOTA BENGKULU</h4>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA / NIP</th>
                <th>PANGKAT / GOL.</th>
                <th>JABATAN</th>
                <th>TANGGAL LAHIR</th>
                <th class="text-center">USIA SAAT INI</th>
                <th class="text-center">TMT PENSIUN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pegawais as $index => $pegawai)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        {{ $pegawai->nama_lengkap }}<br>
                        NIP. {{ $pegawai->user->nip }}
                    </td>
                    <td>{{ $pegawai->pangkat_golongan }}</td>
                    <td>{{ $pegawai->jabatan }}</td>
                    <td>{{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->age }} Tahun</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->addYears($usiaPensiun)->addMonth()->startOfMonth()->translatedFormat('d F Y') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada pegawai yang akan pensiun dalam rentang waktu ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
