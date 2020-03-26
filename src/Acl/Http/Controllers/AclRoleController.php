<?php

namespace Zento\Acl\Http\Controllers;

use DB;
use Auth;
use Route;
use Request;
use Illuminate\Support\Facades\Validator;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\Acl\Model\Auth\Customer;
use Zento\Acl\Model\Auth\Administrator;
use Zento\Acl\Model\ORM\AclRole;
use Zento\Acl\Model\ORM\AclRoleUser;
use Zento\Acl\Model\ORM\AclRoute;
use Zento\Acl\Model\ORM\AclRoleRoute;
use Zento\Acl\Model\ORM\AclWhiteList;
use Zento\Acl\Model\ORM\AclBlackList;
use Zento\Acl\Consts;

class AclRoleController extends ApiBaseController
{
    use TraitHelper;

    /**
     * Get all roles
     *
     * @response {[
     *  'group0 details',
     *  'group1 details',
     * ]}
     */
    public function roles() {
        $scopes = $this->getScopes();
        $collection = AclRole::whereIn('scope', $scopes);
        return $this->withData($this->applyFilter($collection, ['id', 'name', 'description', 'active'])->paginate());
    }

    public function routes() {
        if ($role = AclRole::find(Route::input('id'))) {
            return $this->withData($role->routes);
        }
        return $this->error(404);
    }

    /**
     * Get a roles's all users
     *
     * @return Array User
     */
    public function users() {
        $scope = Route::input('scope');
        $type = \Illuminate\Support\Str::plural($scope);
        if ($role = AclRole::with(['users.' . $type])
            ->where('id', Route::input('id'))
            ->first()) {
            $data = [];
            foreach($role->groupusers ?? [] as $middle) {
                if ($middle->{$type}) {
                    $data[] = $middle->{$type};
                }
            }
            return $this->withData($data);
        }
        return $this->error(404);
    }

    public function userWithCandidate() {
        $scope = Route::input('scope');
        $type = \Illuminate\Support\Str::plural($scope);
        $userClass = $this->getUserModel();
        $joinTable = with(new AclRoleUser)->getTable();
        $userTable = with(new $userClass)->getTable();
        $pagnation = $userClass::leftJoin($joinTable, 
            function ($join) use($joinTable, $userTable) {
                $join->on(sprintf('%s.id', $userTable), '=', sprintf('%s.user_id', $joinTable))
                    ->on(sprintf('%s.role_id', $joinTable), '=', DB::raw(Route::input('id')));
            })
            ->select(sprintf('%s.*', $userTable), sprintf('%s.role_id', $joinTable))
            ->paginate(10);
        return $this->withData($pagnation);
    }

    public function storeUsers() {
        $error = '';
        if ($role = AclRole::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $model = $this->getUserModel();
                $uids = $model::whereIn('id', $ids)->pluck('id')->toArray();
                $exists = AclRoleUser::where('scope', $this->getScope())
                    ->where('role_id', $role->id)
                    ->whereIn('user_id', $uids)->pluck('user_id')->toArray();
                $uids = array_diff($uids, $exists);
                foreach($uids as $id) {
                    AclRoleUser::create([
                        'scope' => $this->getScope(),
                        'user_id'=> $id, 
                        'role_id' => $role->id]);
                }
                return $this->success(201);
            }
        } else {
            $error = 'Group not found';
        }
        return $this->error(400, $error);
    }

    public function deleteUser() {
        if ($role = AclRole::find(Route::input('id'))) {
            if ($user_id = Route::input('user_id')) {
                $user_ids = explode(',', $user_id);
                AclRoleUser::where('scope', $this->getScope())->whereIn('user_id', $user_ids)->delete();
                return $this->with('user_id', Route::input('user_id'));
            }
        }
        return $this->error();
    }

    public function store() {
        if ($name = Request::get('name', false)) {
            $scope = $this->getScope();
            if (AclRole::where('scope', '=', $scope)->where('name', $name)->first()) {
                return $this->error(400, sprintf('Role[%s] exists.', $name));
            }
            $role = new AclRole([
                'scope' => $scope, 
                'name' => $name, 
                'description' => Request::get('description', ''), 
                'active' => Request::get('active', 1)
                ]);
            $role->save();
            return $this->withData($role);
        } else {
            return $this->error(400, 'parameters not valid');
        }
    }

    public function update() {
        if ($id = Route::input('id', false)) {
            $scope = $this->getScope();
            if ($role = AclRole::find($id)) {
                $name = Request::get('name', $role->name);
                if (AclRole::where('scope', '=', $scope)->where('name', $name)->where('id', '!=', $id)->first()) {
                    return $this->error(400, sprintf('Group[%s] has been taken by other group.', $name));
                }
                $role->name = $name;
                $role->description =  Request::get('description', $role->description);
                $role->active =  Request::get('active', $role->active);
                $role->save();
                return $this->withData($role);
            }
            return $this->error(400, sprintf('Group[%s] not exists.', $id));
        } else {
            return $this->error(400, 'parameters not valid');
        }
    }

    public function storeRoutes() {
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
                foreach($ids as $id) {
                    AclRoleRoute::create([
                        'scope' => $this->getScope(),
                        'route_id'=>$id, 
                        'role_id' => $role->id]);
                }
                return $this->success(201);
            }
        }
        return $this->error();
    }

    public function deleteRoutes() {
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
