<!DOCTYPE html>
<html>

<head>
    <title>Rekapitulasi Jabatan</title>
    <style>
        /* ... CSS untuk PDF seperti Laporan DUK ... */
    </style>
</head>

<body>
    <h3>REKAPITULASI KEADAAN PEGAWAI</h3>
    <h4>DI LINGKUNGAN {{ strtoupper($opd->nama_opd) }}</h4>
    <h4>KEADAAN BULAN {{ strtoupper(now()->translatedFormat('F Y')) }}</h4>

    <p><strong>1. Berdasarkan Jenis Kelamin</strong></p>
    <table>
        <thead>
            <tr>
                <th>JENIS KELAMIN</th>
                <th>JUMLAH</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Laki-laki</td>
                <td class="text-center">{{ $jumlah_lk }}</td>
            </tr>
            <tr>
                <td>Perempuan</td>
                <td class="text-center">{{ $jumlah_pr }}</td>
            </tr>
            <tr>
                <td><strong>TOTAL</strong></td>
                <td class="text-center"><strong>{{ $jumlah_lk + $jumlah_pr }}</strong></td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top: 20px;"><strong>2. Berdasarkan Jabatan Struktural (Eselon)</strong></p>
    <table>
        <thead>
            <tr>
                <th>ESELON</th>
                <th>JUMLAH</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>II/a</td>
                <td class="text-center">{{ $eselon_2a }}</td>
            </tr>
            <tr>
                <td>II/b</td>
                <td class="text-center">{{ $eselon_2b }}</td>
            </tr>
            <tr>
                <td>III/a</td>
                <td class="text-center">{{ $eselon_3a }}</td>
            </tr>
            <tr>
                <td>III/b</td>
                <td class="text-center">{{ $eselon_3b }}</td>
            </tr>
            <tr>
                <td>IV/a</td>
                <td class="text-center">{{ $eselon_4a }}</td>
            </tr>
            <tr>
                <td>IV/b</td>
                <td class="text-center">{{ $eselon_4b }}</td>
            </tr>
            <tr>
                <td><strong>TOTAL</strong></td>
                <td class="text-center">
                    <strong>{{ $eselon_2a + $eselon_2b + $eselon_3a + $eselon_3b + $eselon_4a + $eselon_4b }}</strong>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
