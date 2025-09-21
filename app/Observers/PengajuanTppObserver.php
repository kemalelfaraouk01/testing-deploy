<?php

namespace App\Observers;

use App\Models\PengajuanTpp;

class PengajuanTppObserver
{
    /**
     * Handle the PengajuanTpp "created" event.
     *
     * @param  \App\Models\PengajuanTpp  $pengajuanTpp
     * @return void
     */
    public function created(PengajuanTpp $pengajuanTpp)
    {
        // Logic removed to prevent sending emails for draft submissions
    }

    /**
     * Handle the PengajuanTpp "updated" event.
     *
     * @param  \App\Models\PengajuanTpp  $pengajuanTpp
     * @return void
     */
    public function updated(PengajuanTpp $pengajuanTpp)
    {
        //
    }
}