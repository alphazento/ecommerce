<?php

namespace Zento\Acl\Http\Controllers;

use Auth;
use Route;
use Request;
use Illuminate\Support\Facades\Validator;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\Acl\Model\Auth\Customer;
use Zento\Acl\Model\Auth\Administrator;
use Zento\Acl\Model\ORM\AclUserGroup;
use Zento\Acl\Model\ORM\AclGroupUserList;
use Zento\Acl\Model\ORM\AclPermissionItem;
use Zento\Acl\Model\ORM\AclGroupPermission;
use Zento\Acl\Model\ORM\AclUserPermissionWhiteList;
use Zento\Acl\Model\ORM\AclUserPermissionBlackList;
use Zento\Acl\Consts;

class AclController extends ApiBaseController
{
    /**
     * Get all admin users including inactived users
     *
     * @response {[
     *  'user0 details',
     *  'user1 details',
     * ]}
     */
    public function users() {
        $model = $this->getUserModel();
        return $this->withData($model::all());
    }

    protected function getUserModel() {
        $scope = Route::input('scope');
        $model = '';
        switch($scope) {
            case 'administrator':
                $model = Administrator::class;
                break;
            case 'customer':
            default;
                $model = Customer::class;
                break;
        }
        return $model;
    }

    protected function getScope() {
        $scope = Route::input('scope');
        switch($scope) {
            case 'administrator':
                return Consts::ADMIN_SCOPE;
            case 'customer':
                return Consts::FRONTEND_SCOPE;
            case 'all':
                return Consts::BOTH_SCOPE;
            default:
                return Consts::GUEST_SCOPE;
        }
        return Consts::GUEST_SCOPE;
    }

    protected function getScopes() {
        $scope = Route::input('scope');
        switch($scope) {
            case 'administrator':
                return [Consts::ADMIN_SCOPE, Consts::BOTH_SCOPE];
            case 'customer':
                return [Consts::FRONTEND_SCOPE, Consts::BOTH_SCOPE];
            case 'all':
                return [Consts::GUEST_SCOPE, Consts::FRONTEND_SCOPE, Consts::ADMIN_SCOPE, Consts::BOTH_SCOPE];
            default:
                return [\Zento\Acl\Consts::GUEST_SCOPE];
        }
        return [\Zento\Acl\Consts::GUEST_SCOPE];
    }

    /**
     * Get all admin users including inactived users
     *
     * @response {[
     *  'user0 details',
     *  'user1 details',
     * ]}
     */
    public function getUser() {
        $id = Route::input('id');
        if ($id == 'me') {
            return $this->withData(Auth::user());
        }
        $model = $this->getUserModel();
        if ($user = $model::find($id)) {
            return $this->withData($user);
        }
        return $this->error(404);
    }

    public function getUserPermissions() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return $this->withData($user->permissions());
        }
        return $this->error(404);
    }

    public function getUserWhitePermissions() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return $this->withData($user->permissionwhitelist);
        }
        return $this->error(404);
    }

    public function getUserBlackPermissions() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return $this->withData($user->permissionblacklist);
        }
        return $this->error(404);
    }

    public function addUserWhitePermission() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $ids = AclPermissionItem::whereIn('id', $ids)->pluck('id')->toArray();
                $exists = AclUserPermissionWhiteList::where('user_id', $user->id)->whereIn('item_id', $ids)->pluck('item_id')->toArray();
                $pids = array_diff($ids, $exists);
                foreach($pids as $id) {
                    AclUserPermissionWhiteList::create(['user_id'=>$user->id, 'item_id' => $id]);
                }
                AclUserPermissionBlackList::where('user_id', $user->id)->whereIn('item_id', $ids)->delete();
                return $this->success(201);
            }
            return $this->success();
        }
        return $this->error(404);
    }

    public function addUserBlackPermission() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $ids = AclPermissionItem::whereIn('id', $ids)->pluck('id')->toArray();
                $exists = AclUserPermissionBlackList::where('user_id', $user->id)->whereIn('item_id', $ids)->pluck('item_id')->toArray();
                $pids = array_diff($ids, $exists);
                foreach($pids as $id) {
                    AclUserPermissionBlackList::create(['user_id'=>$user->id, 'item_id' => $id]);
                }
                AclUserPermissionWhiteList::where('user_id', $user->id)->whereIn('item_id', $pids)->delete();
                return $this->success(201);
            }
            return $this->success();
        }
        return $this->error(404);
    }

    public function removeUserWhitePermission() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('uid'))) {
            if ($pid = Route::input('pid')) {
                $pids = explode(',', $pid);
                AclUserPermissionWhiteList::where('user_id', $user->id)->whereIn('item_id', $pids)->delete();
            }
            return $this->success();
        }
        return $this->error(404);
    }


    public function removeUserBlackPermission() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('uid'))) {
            if ($pid = Route::input('pid')) {
                $pids = explode(',', $pid);
                AclUserPermissionBlackList::where('user_id', $user->id)->whereIn('item_id', $pids)->delete();
            }
            return $this->success();
        }
        return $this->error(404);
    }

    public function getGroupsByUser() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return $this->withData($user->groups);
        }
        return $this->error(404);
    }

    /**
     * Get all admin groups
     *
     * @response {[
     *  'group0 details',
     *  'group1 details',
     * ]}
     */
    public function groups() {
        return $this->withData(AclUserGroup::whereIn('scope', $this->getScopes())->get());
    }

    public function getGroupPermissions() {
        if ($group = AclUserGroup::find(Route::input('id'))) {
            return $this->withData($group->permissions);
        }
        return $this->error(404);
    }

    /**
     * Get a group's all users
     *
     * @return Array User
     */
    public function getGroupUsers() {
        $scope = Route::input('scope');
        $type = \Illuminate\Support\Str::plural($scope);
        if ($group = AclUserGroup::with(['groupusers.' . $type])->where('id', Route::input('id'))->first()) {
            $data = [];
            foreach($group->groupusers ?? [] as $middle) {
                if ($middle->{$type}) {
                    $data[] = $middle->{$type};
                }
            }
            return $this->withData($data);
        }
        return $this->error(404);
    }

    /**
     * Get config values by input keys
     *
     * @bodyParam keys string required The configs keys string(seperated by ;).
     * @response {
     *  "key0": "value0",
     *  "key1": "value1"
     * }
     */
    public function putUser() {
        $data = Request::only('email', 'name');
        $validator = Validator::make($data, [
            'email' => 'required|max:255|email',
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return $this->error(400, json_encode($validator->errors()));
        }

        $password = Request::get('password', '');
        if ($password != Request::get('password', '')) {
            return $this->error(400, 'password and confirm password not match.');
        }

        $model = $this->getUserModel();
        if ($id = Request::get('id', false)) {
            $user = $model::find($id);
            $user->name = $data['name'];
        } else {
            $validator = Validator::make(['password' => $password], [
                'password' => 'required|max:16|min:8'
            ]);
            if ($validator->fails()) {
                return $this->error(400, json_encode($validator->errors()));
            }
            if ($model::where('email', $data['email'])->exists()) {
                return $this->error(400, $data['email'] . ' has exists');
            }
            $user = new $model($data);
        }

        if (!empty($password)) {
            $user->password = $user->encryptPassword($password);
        }

        $user->save();
        return $this->withData($user);
    }

    /**
     * set config key value pair by input key value pair items
     *
     * @bodyParam key0 string required The first key value pair
     * @bodyParam key2 string required The second key value pair
     * @response {
     *  "key0": "value0",
     *  "key1": "value1"
     * }
     */
    public function deleteUser() {
        $id = Route::input('id');
        $model = $this->getUserModel();
        if ($user = $model::find($id)) {
            $user->delete();
            return $this->with('id', $id);
        }
        return $this->error();
    }

    public function updateUser() {
        $id = Route::input('id');
        $params = Request::get('data');
        $model = $this->getUserModel();
        if ($user = $model::find($id)) {
            foreach($params as $key=>$value) {
                switch($key) {
                    case 'id':
                    case 'password':
                        break;
                    default:
                        $user->{$key} = $value;
                        break;
                }
            }
            $user->save();
            $params['id'] = $id;
            return $this->withData($params);
        }
        return $this->error()->withData($pa);
    }

    public function addUsersToGroup() {
        $error = '';
        if ($group = AclUserGroup::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $model = $this->getUserModel();
                $uids = $model::whereIn('id', $ids)->pluck('id')->toArray();
                $exists =  AclGroupUserList::where('scope', $this->getScope())
                    ->where('group_id', $group->id)
                    ->whereIn('user_id', $uids)->pluck('user_id')->toArray();
                $uids = array_diff($uids, $exists);
                foreach($uids as $id) {
                    AclGroupUserList::create([
                        'scope' => $this->getScope(),
                        'user_id'=>$id, 
                        'group_id' => $group->id]);
                }
                return $this->success(201);
            }
        } else {
            $error = 'Group not found';
        }
        return $this->error(400, $error);
    }

    public function removeUserFromGroup() {
        if ($group = AclUserGroup::find(Route::input('group_id'))) {
            if ($user_id = Route::input('user_id')) {
                $user_ids = explode(',', $user_id);
                AclGroupUserList::where('scope', $this->getScope())->whereIn('user_id', $user_ids)->delete();
                return $this->with('user_id', Route::input('user_id'));
            }
        }
        return $this->error();
    }

    public function addGroup() {
        if ($name = Request::get('name', false)) {
            $scope = $this->getScope();
            if (AclUserGroup::where('scope', '=', $scope)->where('name', $name)->first()) {
                return $this->error(400, sprintf('Group[%s] already exists.', $name));
            }
            $group = new AclUserGroup([
                'scope' => $scope, 
                'name' => $name, 
                'description' => Request::get('description', ''), 
                'active' => Request::get('active', 1)
                ]);
            $group->save();
            return $this->withData($group);
        } else {
            return $this->error(400, 'parameters not valid');
        }
    }

    public function updateGroup() {
        if ($id = Route::input('id', false)) {
            $scope = $this->getScope();
            if ($group = AclUserGroup::find($id)) {
                $name = Request::get('name', $group->name);
                if (AclUserGroup::where('scope', '=', $scope)->where('name', $name)->where('id', '!=', $id)->first()) {
                    return $this->error(400, sprintf('Group[%s] has been taken by other group.', $name));
                }
                $group->name = $name;
                $group->description =  Request::get('description', $group->description);
                $group->active =  Request::get('active', $group->active);
                $group->save();
                return $this->withData($group);
            }
            return $this->error(400, sprintf('Group[%s] not exists.', $id));
        } else {
            return $this->error(400, 'parameters not valid');
        }
    }

    public function addGroups2User() {
        $error = '';
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $gids = AclUserGroup::where('scope',$this->getScope())->whereIn('id', $ids)->pluck('id')->toArray();
                foreach($gids as $gid) {
                    AclGroupUserList::create([
                        'scope' => $this->getScope(),
                        'user_id'=>$user->id, 'group_id' => $gid]);
                }
                return $this->success(201);
            }
        } else {
            $error = 'User not found';
        }
        return $this->error(400, $error);
    }

    public function getPermissions() {
        return $this->withData(AclPermissionItem::where('active', 1)->get());
    }

    public function addGroupPermissions() {
        if ($group = AclUserGroup::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $ids = AclPermissionItem::whereIn('id', $ids)->pluck('id')->toArray();
                $exists = AclGroupPermission::where('group_id', $group->id)
                            ->whereIn('item_id', $ids)->pluck('item_id')->toArray();
                $ids = array_diff($ids, $exists);
                foreach($ids as $id) {
                    AclGroupPermission::create([
                        'scope' => $this->getScope(),
                        'item_id'=>$id, 
                        'group_id' => $group->id]);
                }
                return $this->success(201);
            }
        }
        return $this->error();
    }

    public function removeGroupPermission() {
        if ($group = AclUserGroup::find(Route::input('gid'))) {
            if ($pid = Route::input('pid')) {
                $pids = explode(',', $pid);
                AclGroupPermission::where('group_id', $group->id)->whereIn('item_id', $pids)->delete();
                return $this->success();
            }
        }
        return $this->error();
    }
}
