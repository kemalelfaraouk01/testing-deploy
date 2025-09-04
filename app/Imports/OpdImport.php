<?php

namespace App\Imports;

use App\Models\Opd;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;

class OpdImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Membuat record OPD baru dari setiap baris di Excel
        $opd = new Opd([
            'nama_opd' => $row['nama_opd'],
            'alamat'   => $row['alamat'] ?? null,
        ]);

        // Simpan terlebih dahulu untuk mendapatkan ID
        $opd->save();

        // Buat kode_opd otomatis berdasarkan ID yang baru dibuat
        $opd->kode_opd = 'OPD-' . str_pad($opd->id, 3, '0', STR_PAD_LEFT);
        $opd->save();

        return $opd;
    }

    /**
     * Tentukan aturan validasi untuk setiap baris.
     */
    public function rules(): array
    {
        return [
            'nama_opd' => 'required|string|max:255|unique:opds,nama_opd',
        ];
    }

    /**
     * Kustomisasi pesan error validasi.
     */
    public function customValidationMessages()
    {
        return [
            'nama_opd.required' => 'Kolom nama_opd wajib diisi.',
            'nama_opd.unique'   => 'Nama OPD pada baris :row sudah ada di database.',
        ];
    }
}
