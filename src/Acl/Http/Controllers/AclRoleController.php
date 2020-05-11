<?php

namespace Zento\Acl\Http\Controllers;

use Auth;
use DB;
use Request;
use Route;
use Zento\Acl\Model\Auth\Administrator;
use Zento\Acl\Model\Auth\Customer;
use Zento\Acl\Model\ORM\AclRole;
use Zento\Acl\Model\ORM\AclRoleRoute;
use Zento\Acl\Model\ORM\AclRoleUser;
use Zento\Acl\Model\ORM\AclRoute;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class AclRoleController extends ApiBaseController
{
    use TraitHelper;

    /**
     * Retrieves all roles in a scope
     * @authenticated
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend
     * @responseCollectionPagination \Zento\Acl\Model\ORM\AclRole
     */
    public function roles()
    {
        $scopes = $this->getScopes();
        $collection = AclRole::whereIn('scope', $scopes);
        return $this->withData($this->applyFilter($collection, ['id', 'name', 'description', 'active'])->paginate());
    }

    /**
     * Retrieves all routes which the role can access
     * @authenticated
     * @group ACL Management
     * @urlParam id required number the role's ID
     * @responseCollection \Zento\Acl\Model\ORM\AclRole
     */
    public function routes()
    {
        if ($role = AclRole::find(Route::input('id'))) {
            return $this->withData($role->routes);
        }
        return $this->error(404);
    }

    /**
     * Retrieves all users belongs to the role
     * @authenticated
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend. Example:administrator
     * @urlParam id required number the role's ID Example:1
     */
    public function users()
    {
        $scope = Route::input('scope');
        $type = \Illuminate\Support\Str::plural($scope);
        if ($role = AclRole::with(['users.' . $type])
            ->where('id', Route::input('id'))
            ->first()) {
            $data = [];
            foreach ($role->groupusers ?? [] as $middle) {
                if ($middle->{$type}) {
                    $data[] = $middle->{$type};
                }
            }
            return $this->withData($data);
        }
        return $this->error(404);
    }

    /**
     * Retrieves all users belongs to the role and also users not belongs to the roles
     * @authenticated
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend. Example:administrator
     * @urlParam id required number the role's ID Example:1
     */
    public function usersWithCandidates()
    {
        $scope = Route::input('scope');
        $type = \Illuminate\Support\Str::plural($scope);
        $userClass = $this->getUserModel();
        $joinTable = with(new AclRoleUser)->getTable();
        $userTable = with(new $userClass)->getTable();
        $pagnation = $userClass::leftJoin($joinTable,
            function ($join) use ($joinTable, $userTable) {
                $join->on(sprintf('%s.id', $userTable), '=', sprintf('%s.user_id', $joinTable))
                    ->on(sprintf('%s.role_id', $joinTable), '=', DB::raw(Route::input('id')));
            })
            ->select(sprintf('%s.*', $userTable), sprintf('%s.role_id', $joinTable))
            ->paginate(10);
        return $this->withData($pagnation);
    }

    /**
     * Assign users to the role
     * @authenticated
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend. Example:administrator
     * @urlParam id required number the role's ID
     * @bodyParam ids required users' ID
     */
    public function storeUsers()
    {
        $error = '';
        if ($role = AclRole::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $model = $this->getUserModel();
                $uids = $model::whereIn('id', $ids)->pluck('id')->toArray();
                $exists = AclRoleUser::where('scope', $this->getScope())
                    ->where('role_id', $role->id)
                    ->whereIn('user_id', $uids)->pluck('user_id')->toArray();
                $uids = array_diff($uids, $exists);
                foreach ($uids as $id) {
                    AclRoleUser::create([
                        'scope' => $this->getScope(),
                        'user_id' => $id,
                        'role_id' => $role->id]);
                }
                return $this->success(201);
            }
        } else {
            $error = 'Group not found';
        }
        return $this->error(400, $error);
    }

    /**
     * De-assign users from the role
     * @authenticated
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend. Example:administrator
     * @urlParam id required number the role's ID
     * @bodyParam user_id required users' ID
     */
    public function deleteUser()
    {
        if ($role = AclRole::find(Route::input('id'))) {
            if ($user_id = Route::input('user_id')) {
                $user_ids = explode(',', $user_id);
                AclRoleUser::where('scope', $this->getScope())->whereIn('user_id', $user_ids)->delete();
                return $this->with('user_id', Route::input('user_id'));
            }
        }
        return $this->error();
    }

    /**
     * Create a new role
     * @authenticated
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend. Example:administrator
     * @queryParam name required new role's name
     */
    public function store()
    {
        if ($name = Request::get('name', false)) {
            $scope = $this->getScope();
            if (AclRole::where('scope', '=', $scope)->where('name', $name)->first()) {
                return $this->error(400, sprintf('Role[%s] exists.', $name));
            }
            $role = new AclRole([
                'scope' => $scope,
                'name' => $name,
                'description' => Request::get('description', ''),
                'active' => Request::get('active', 1),
            ]);
            $role->save();
            return $this->withData($role);
        } else {
            return $this->error(400, 'parameters not valid');
        }
    }

    /**
     * Update role's details
     * @authenticated
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend. Example:administrator
     * @urlParam id required number the role's ID
     * @queryParam name required role's name
     */
    public function update()
    {
        if ($id = Route::input('id', false)) {
            $scope = $this->getScope();
            if ($role = AclRole::find($id)) {
                $name = Request::get('name', $role->name);
                if (AclRole::where('scope', '=', $scope)->where('name', $name)->where('id', '!=', $id)->first()) {
                    return $this->error(400, sprintf('Group[%s] has been taken by other group.', $name));
                }
                $role->name = $name;
                $role->description = Request::get('description', $role->description);
                $role->active = Request::get('active', $role->active);
                $role->save();
                return $this->withData($role);
            }
            return $this->error(400, sprintf('Group[%s] not exists.', $id));
        } else {
            return $this->error(400, 'parameters not valid');
        }
    }

    /**
     * Assign users to the role
     * @authenticated
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend. Example:administrator
     * @urlParam id required number the role's ID
     * @bodyParam ids required route's IDs
     */
    public function storeRoutes()
    {
        if ($role = AclRole::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $ids = AclRoute::whereIn('id', $ids)->pluck('id')->toArray();
                AclRoleRoute::where('role_id', $role->id)
                    ->whereNotIn('route_id', $ids)
                    ->delete();

                $exists = AclRoleRoute::where('role_id', $role->id)
                    ->whereIn('route_id', $ids)
                    ->pluck('route_id')
                    ->toArray();

                $ids = array_diff($ids, $exists);
                foreach ($ids as $id) {
                    AclRoleRoute::create([
                        'scope' => $this->getScope(),
                        'route_id' => $id,
                        'role_id' => $role->id]);
                }
                return $this->success(201);
            }
        }
        return $this->error();
    }

    /**
     * De-assign routes from the role
     * @authenticated
     * @group ACL Management
     * @urlParam id required number the role's ID
     * @bodyParam user_id required route's IDs
     */
    public function deleteRoutes()
    {
        if ($role = AclRole::find(Route::input('id'))) {
            if ($route_id = Route::input('route_id')) {
                $route_ids = explode(',', $route_id);
                AclRoleRoute::where('role_id', $role->id)->whereIn('route_id', $route_ids)->delete();
                return $this->success();
            }
        }
        return $this->error();
    }
}
