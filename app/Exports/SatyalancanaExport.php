<?php

namespace App\Exports;

use App\Models\Satyalancana;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SatyalancanaExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    private $rowNumber = 0;
    protected $periode;

    public function __construct($periode = null)
    {
        $this->periode = $periode;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Satyalancana::query()
            ->with('pegawai.user')
            ->when($this->periode, function ($query) {
                return $query->where('periode', $this->periode);
            });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'no',
            'NIP',
            'Nama',
            'KdPangkat',
            'Jabatan',
            'Slks Lama',
            'NoKeppres',
            'TglKeppres',
            'SlksUsul',
            'Bulanp',
            'Tahunp',
            'KabKota',
            'Provinsi',
            'KdWil',
            'MsTms',
        ];
    }

    /**
     * @param Satyalancana $satyalancana
     * @return array
     */
    public function map($satyalancana): array
    {
        $this->rowNumber++;

        // Parsing periode untuk mendapatkan bulan dan tahun
        [$bulan, $tahun] = explode(' ', $satyalancana->periode);

        return [
            $this->rowNumber,
            $satyalancana->pegawai?->user?->nip ?? 'N/A',
            $satyalancana->pegawai?->nama_lengkap ?? 'N/A',
            $satyalancana->pegawai?->golongan ?? 'N/A', // Asumsi KdPangkat adalah golongan
            $satyalancana->pegawai?->jabatan ?? 'N/A',
            $satyalancana->slks_lama,
            $satyalancana->no_keppres,
            $satyalancana->tanggal_keppres,
            $satyalancana->masa_kerja . ' Tahun', // SlksUsul
            $bulan, // Bulanp
            $tahun, // Tahunp
            'Kota Bengkulu', // KabKota (Hardcoded)
            'Prov. Bengkulu', // Provinsi (Hardcoded)
            '003', // KdWil (Hardcoded)
            $satyalancana->ms_tms,
        ];
    }
}
