<?php

namespace Zento\Backend\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Zento\Backend\Services\AdminDashboardService;
use Zento\Passport\Model\User;

class DashboardUxPolicy
{
    use HandlesAuthorization;

    public function showMenu(User $administrator,
        AdminDashboardService $dashBoardService,
        $menuItem = null
    ) {
        return true;
    }
}
