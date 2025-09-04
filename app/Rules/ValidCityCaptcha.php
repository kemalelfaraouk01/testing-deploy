<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidCityCaptcha implements Rule
{
    /**
     * Daftar jawaban yang benar (dalam huruf kecil).
     *
     * @var array
     */
    protected $validCities = [
        'bengkulu',
        'curup',
        'manna',
        'arga makmur',
        'mukomuko',
        'kepahiang',
        'tais',
    ];

    /**
     * Menentukan apakah aturan validasi lolos.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Ubah input pengguna menjadi huruf kecil dan periksa apakah ada di dalam daftar
        return in_array(strtolower($value), $this->validCities);
    }

    /**
     * Mendapatkan pesan error validasi.
     *
     * @return string
     */
    public function message()
    {
        return 'Jawaban CAPTCHA tidak valid.';
    }
}
