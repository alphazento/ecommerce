<?php

namespace Zento\Backend\Policies;

use Zento\Passport\Model\User;
use Zento\Backend\Services\AdminDashboardService;

use Illuminate\Auth\Access\HandlesAuthorization;

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
