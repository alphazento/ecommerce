<?php

namespace Zento\Acl\Policies;

use Zento\Passport\Model\User;
use Zento\Backend\Services\AdminDashboardService;
use Illuminate\Auth\Access\HandlesAuthorization;

class DashboardUxPolicy extends \Zento\Backend\Policies\DashboardUxPolicy
{
    public function showMenu(User $user, 
        AdminDashboardService $dashBoardService, 
        $menuPaths = []) 
    {
        return true;
    }
}
