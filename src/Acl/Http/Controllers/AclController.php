<?php

namespace Zento\Acl\Http\Controllers;

use Route;
use Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Zento\Acl\Model\Auth\Customer;
use Zento\Acl\Model\Auth\Administrator;
use Zento\Acl\Model\ORM\AclUserGroup;
use Zento\Acl\Model\ORM\AclGroupUser;
use Zento\Acl\Model\ORM\AclPermissionItem;
use Zento\Acl\Model\ORM\AclGroupPermission;
use Zento\Acl\Model\ORM\AclUserPermissionWhiteList;
use Zento\Acl\Model\ORM\AclUserPermissionBlackList;
use Zento\Acl\Consts;

class AclController extends Controller
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
        return ['status' => 200, 'data' => $model::all()];
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
        $model = $this->getUserModel();
        return ['status' => 200, 'data' => $model::all()];
    }

    public function getUserPermissions() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return ['status' => 200, 'data' => $user->permissions()];
        }
        return ['status'=>404];
    }

    public function getUserWhitePermissions() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return ['status' => 200, 'data' => $user->permissionwhitelist];
        }
        return ['status'=>404];
    }

    public function getUserBlackPermissions() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return ['status' => 200, 'data' => $user->permissionblacklist];
        }
        return ['status'=>404];
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
                return ['status'=> 201];
            }

            return ['status' => 200];
        }
        return ['status'=>404];
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
                return ['status'=> 201];
            }

            return ['status' => 200];
        }
        return ['status'=>404];
    }

    public function removeUserWhitePermission() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('uid'))) {
            if ($pid = Route::input('pid')) {
                $pids = explode(',', $pid);
                AclUserPermissionWhiteList::where('user_id', $user->id)->whereIn('item_id', $pids)->delete();
            }
            return ['status' => 200];
        }
        return ['status'=>404];
    }


    public function removeUserBlackPermission() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('uid'))) {
            if ($pid = Route::input('pid')) {
                $pids = explode(',', $pid);
                AclUserPermissionBlackList::where('user_id', $user->id)->whereIn('item_id', $pids)->delete();
            }

            return ['status' => 200];
        }
        return ['status'=>404];
    }

    public function getGroupsByUser() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return ['status' => 200, 'data' => $user->groups];
        }
        return ['status'=>404];
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
        return ['status' => 200, 'data' => AclUserGroup::whereIn('scope', $this->getScopes())->get()];
    }

    public function getGroupPermissions() {
        if ($group = AclUserGroup::find(Route::input('id'))) {
            return ['status' => 200, 'data' => $group->permissions];
        }
        return ['status'=>404];
    }

    /**
     * Get a group's all users
     *
     * @return Array User
     */
    public function getGroupUsers() {
        if ($group = AclUserGroup::with(['groupusers.user'])->where('id', Route::input('id'))->first()) {
            $data = [];
            foreach($group->groupusers ?? [] as $middle) {
                if ($middle->user) {
                    $data[] = $middle->user;
                }
            }
            return ['status' => 200, 'data' => $data];
        }
        return ['status'=>404];
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
        $data = Request::only('email','first_name', 'last_name');
        $validator = Validator::make($data, [
            'email' => 'required|max:255|email',
            'first_name' => 'required|max:128',
            'last_name' => 'required|max:128'
        ]);

        if ($validator->fails()) {
            return ['status' => 400, 'error' => json_encode($validator->errors())];
        }

        $password = Request::get('password', '');
        if ($password != Request::get('password', '')) {
            return ['status' => 400, 'error' => 'password and confirm password not match.'];
        }

        if ($id = Request::get('id', false)) {
            $user = User::find($id);
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
        } else {
            $validator = Validator::make(['password' => $password], [
                'password' => 'required|max:16|min:8'
            ]);
            if ($validator->fails()) {
                return ['status' => 400, 'error' => json_encode($validator->errors())];
            }
            if (User::where('email', $data['email'])->exists()) {
                return ['status'=>'400', 'error' => $data['email'] . ' has exists'];
            }
            $user = new User($data);
        }

        if (!empty($password)) {
            $user->password = $user->encryptPassword($password);
        }
        $user->name = sprintf('%s %s', $user->first_name, $user->last_name);

        $user->save();
        return ['status'=>'200', 'data' => $user];
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
        if ($user = User::find($id)) {
            $user->delete();
            return ['status'=>200, 'data' => ['id' => $id]];
        }
        return ['status'=>400];
    }

    public function updateUser() {
        $id = Route::input('id');
        $params = Request::get('data');
        if ($user = User::find($id)) {
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
            return ['status'=>200, 'data' => $params];
        }
        return ['status'=>400, $params];
    }

    public function addUsersToGroup() {
        $error = '';
        if ($group = AclUserGroup::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $uids = User::whereIn('id', $ids)->pluck('id')->toArray();
                $exists =  AclUserGroupUser::where('group_id', $group_id)->whereIn('user_id', $uids)->pluck('user_id')->toArray();
                $uids = array_diff($uids, $exists);
                foreach($uids as $id) {
                    AclUserGroupUser::create(['user_id'=>$id, 'group_id' => $group->id]);
                }
                return ['status'=> 201];
            }
        } else {
            $error = 'Group not found';
        }
        return ['status' => 400, 'error' => $error];
    }

    public function removeUserFromGroup() {
        if ($group = AclUserGroup::find(Route::input('group_id'))) {
            if ($item = AclUserGroupUser::where('user_id', Route::input('user_id'))) {
                $item->delete();
                return ['status' => 200, 'data' => Route::input('user_id')];
            }
        }
        return ['status' => 400];
    }

    public function addGroup() {
        if ($name = Request::get('name', false)) {
            if (AclUserGroup::where('name', $name)->first()) {
                return ['status'=>'400', 'error' => sprintf('Group[%s] already exists.', $name)];
            }
            $group = new AclUserGroup(['name' => $name, 'description' => Request::get('description', ''), 'active' => Request::get('active', 1)]);
            $group->save();
            return ['status'=>'200', 'data' => $group];
        } else {
            return ['status'=>'400', 'error' => 'parameters not valid'];
        }
    }

    public function updateGroup() {
        if ($id = Route::input('id', false)) {
            if ($group = AclUserGroup::find($id)) {
                $name = Request::get('name', $group->name);
                if (AclUserGroup::where('name', $name)->where('id', '!=', $id)->first()) {
                    return ['status'=>'400', 'error' => sprintf('Group[%s] has been taken by other group.', $name)];
                }
                $group->name = $name;
                $group->description =  Request::get('description', $group->description);
                $group->active =  Request::get('active', $group->active);
                $group->save();
                return ['status'=>'200', 'data' => $group];
            }
            return ['status'=>'400', 'error' => sprintf('Group[%s] not exists.', $id)];
        } else {
            return ['status'=>'400', 'error' => 'parameters not valid'];
        }
    }

    public function addGroups2User() {
        $error = '';
        if ($user = User::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $gids = AclUserGroup::whereIn('id', $ids)->pluck('id')->toArray();
                foreach($gids as $gid) {
                    AclUserGroupUser::create(['user_id'=>$user->id, 'group_id' => $gid]);
                }
                return ['status'=> 201];
            }
        } else {
            $error = 'User not found';
        }
        return ['status' => 400, 'error' => $error];
    }

    public function getPermissions() {
        return ['status' => 200, 'data' => AclPermissionItem::where('active', 1)->get()];
    }

    public function addGroupPermissions() {
        if ($group = AclUserGroup::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $ids = AclPermissionItem::whereIn('id', $ids)->pluck('id')->toArray();
                $exists = AclUserGroupPermission::where('group_id', $group->id)
                            ->whereIn('item_id', $ids)->pluck('item_id')->toArray();
                $ids = array_diff($ids, $exists);
                foreach($ids as $id) {
                    AclUserGroupPermission::create(['item_id'=>$id, 'group_id' => $group->id]);
                }
                return ['status'=> 201];
            }
        }
        return ['status' => 400];
    }

    public function removeGroupPermission() {
        if ($group = AclUserGroup::find(Route::input('gid'))) {
            if ($pid = Route::input('pid')) {
                $pids = explode(',', $pid);
                if ($item =  AclUserGroupPermission::where('group_id', $group->id)->whereIn('item_id', $pids)->first()) {
                    $item->delete();
                }
                return ['status'=> 200];
            }
        }
        return ['status' => 400];
    }
}
