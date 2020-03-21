<?php

namespace Zento\Acl\Http\Controllers;

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
use Zento\Acl\Model\ORM\AclWhiteList;
use Zento\Acl\Model\ORM\AclBlackList;
use Zento\Acl\Consts;

class AclUserController extends ApiBaseController
{
    use TraitHelper;

    /**
     * Get current token's user details 
     */
    public function me() {
        return $this->withData(Auth::user());
    } 

    /**
     * Get user by id
     */
    public function user() {
        if ($id = Route::input('id')) {
            $model = $this->getUserModel();
            if ($user = $model::find($id)) {
                return $this->withData($user);
            }
        }
        return $this->error(404);
    }

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

    /**
     * Get config values by input keys
     *
     * @bodyParam keys string required The configs keys string(seperated by ;).
     * @response {
     *  "key0": "value0",
     *  "key1": "value1"
     * }
     */
    public function store() {
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

    public function update() {
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
    public function delete() {
        $id = Route::input('id');
        $model = $this->getUserModel();
        if ($user = $model::find($id)) {
            $user->delete();
            return $this->with('id', $id);
        }
        return $this->error();
    }

    public function routes() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return $this->withData($user->permissions());
        }
        return $this->error(404);
    }

    public function whiteroutes() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return $this->withData($user->permissionwhitelist);
        }
        return $this->error(404);
    }

    public function blackroutes() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return $this->withData($user->permissionblacklist);
        }
        return $this->error(404);
    }

    public function storeWhiteRoutes() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            if ($route_ids = Request::get('route_ids')) {
                $route_ids = AclRoute::whereIn('id', $route_ids)->pluck('id')->toArray();
                $exists = AclWhiteList::where('user_id', $user->id)->whereIn('route_id', $route_ids)->pluck('route_id')->toArray();
                $route_ids = array_diff($route_ids, $exists);
                foreach($route_ids as $id) {
                    AclWhiteList::create(['user_id'=>$user->id, 'route_id' => $id]);
                }
                AclBlackList::where('user_id', $user->id)->whereIn('route_id', $route_ids)->delete();
                return $this->success(201);
            }
            return $this->success();
        }
        return $this->error(404);
    }

    public function storeBlackRoutes() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $ids = AclRoute::whereIn('id', $ids)->pluck('id')->toArray();
                $exists = AclBlackList::where('user_id', $user->id)->whereIn('route_id', $ids)->pluck('route_id')->toArray();
                $route_ids = array_diff($ids, $exists);
                foreach($route_ids as $id) {
                    AclBlackList::create(['user_id'=>$user->id, 'route_id' => $id]);
                }
                AclWhiteList::where('user_id', $user->id)->whereIn('route_id', $route_ids)->delete();
                return $this->success(201);
            }
            return $this->success();
        }
        return $this->error(404);
    }

    public function deleteWhiteRoute() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            if ($route_id = Route::input('route_ids')) {
                $route_ids = explode(',', $route_id);
                AclWhiteList::where('user_id', $user->id)->whereIn('route_id', $route_ids)->delete();
            }
            return $this->success();
        }
        return $this->error(404);
    }

    public function deleteBlackRoute() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            if ($route_ids = Route::input('route_ids')) {
                $route_ids = explode(',', $route_ids);
                AclBlackList::where('user_id', $user->id)->whereIn('route_id', $route_ids)->delete();
            }
            return $this->success();
        }
        return $this->error(404);
    }

    public function roles() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return $this->withData($user->roles);
        }
        return $this->error(404);
    }

    public function storeRoles() {
        $error = '';
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $gids = AclRole::where('scope',$this->getScope())->whereIn('id', $ids)->pluck('id')->toArray();
                foreach($gids as $gid) {
                    AclRoleUser::create([
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
}
