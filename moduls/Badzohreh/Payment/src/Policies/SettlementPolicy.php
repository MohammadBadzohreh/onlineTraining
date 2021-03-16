<?php

namespace Badzohreh\Payment\Policies;

use Badzohreh\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettlementPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {

    }

    public function index(User $user)
    {
        dd("s,fcd;");
    }

}
