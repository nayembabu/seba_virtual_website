<?php

namespace App\Policies;

use App\Models\SmartCard;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SmartCardPolicy
{
    use HandlesAuthorization;

    public function view(User $user, SmartCard $smartcard)
    {
        return $user->id === $smartcard->user_id;
    }

    public function update(User $user, SmartCard $smartcard)
    {
        return $user->id === $smartcard->user_id;
    }

    public function delete(User $user, SmartCard $smartcard)
    {
        return $user->id === $smartcard->user_id;
    }
}
