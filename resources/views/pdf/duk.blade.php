<!DOCTYPE html>
<html>

<head>
    <title>Laporan Daftar Urut Kepangkatan (DUK)</title>
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
    <h3>DAFTAR URUT KEPANGKATAN (DUK)</h3>
    <h4>PNS PEMERINTAH KOTA BENGKULU</h4>
    <h4>TAHUN {{ date('Y') }}</h4>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA / NIP</th>
                <th>PANGKAT / GOL. RUANG</th>
                <th>TMT PANGKAT</th>
                <th>JABATAN</th>
                <th>TMT JABATAN</th>
                <th>PENDIDIKAN</th>
                <th>TANGGAL LAHIR</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pegawais as $index => $pegawai)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        {{ $pegawai->nama_lengkap }}<br>
                        NIP. {{ $pegawai->user->nip }}
                    </td>
                    <td>{{ $pegawai->pangkat }} / ({{ $pegawai->golongan }})</td>
                    <td>{{ $pegawai->tmt_pangkat ? \Carbon\Carbon::parse($pegawai->tmt_pangkat)->format('d-m-Y') : '-' }}
                    </td>
                    <td>{{ $pegawai->jabatan }}</td>
                    <td>{{ $pegawai->tmt_jabatan ? \Carbon\Carbon::parse($pegawai->tmt_jabatan)->format('d-m-Y') : '-' }}
                    </td>
                    <td>{{ $pegawai->pendidikan_terakhir }}</td>
                    <td>{{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d-m-Y') : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
