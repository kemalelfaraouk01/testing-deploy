<?php

namespace App\Policies;

use App\Models\Satyalancana;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SatyalancanaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Satyalancana  $satyalancana
     * @return bool
     */
    public function view(User $user, Satyalancana $satyalancana)
    {
        // User bisa melihat jika ID-nya cocok dengan user_id di data pegawai yang terkait
        return $user->id === $satyalancana->pegawai->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Satyalancana  $satyalancana
     * @return bool
     */
    public function update(User $user, Satyalancana $satyalancana)
    {
        // User bisa update jika ID-nya cocok dengan user_id di data pegawai yang terkait
        return $user->id === $satyalancana->pegawai->user_id;
    }
}
