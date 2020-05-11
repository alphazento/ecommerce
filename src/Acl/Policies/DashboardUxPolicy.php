<?php

namespace Zento\Acl\Policies;

use Zento\Backend\Services\AdminDashboardService;
use Zento\Passport\Model\User;

class DashboardUxPolicy extends \Zento\Backend\Policies\DashboardUxPolicy
{
    public function showMenu(User $user,
        AdminDashboardService $dashBoardService,
        $menuPaths = []) {
        return true;
    }
}
