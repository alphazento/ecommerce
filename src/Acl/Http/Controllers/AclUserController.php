<?php

namespace Zento\Acl\Http\Controllers;

use Auth;
use Route;
use Request;
use Illuminate\Support\Facades\Validator;
use Zento\Kernel\Http\Controllers\ApiBaseController;
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
     * Retrieve login user details
     * @authenticated
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend
     * @response {"success":true,"code":200,"locale":"en","message":"",
     * "data":{}
     * }
     */
    public function me() {
        return $this->withData(Auth::user());
    } 

    /**
     * Retrieve user details
     * @authenticated
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend
     * @urlParam id required number user's id
     * @response {"success":true,"code":200,"locale":"en","message":"",
     * "data":{}}
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
     * Retrieve all administrator/customers(accept filter)
     * @authenticated
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend
     * @queryParam id user's id filter
     * @queryParam firstname user's firstname filter
     * @queryParam lastname user's lastname filter
     * @queryParam email user's email filter
     * @queryParam active user's active filter
     * @queryParam page pagination filter
     * @response {"success":true,"code":200,"locale":"en","message":"",
     * "data":[
     *  'user0 details',
     *  'user1 details',
     * ]}
     */
    public function users() {
        $model = $this->getUserModel();
        $collection = $model::select('*');
        return $this->withData($this->applyFilter($collection, ['id', 'firstname', 'lastname', 'email', 'active'])->paginate());
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
     * @authenticated
     * @group ACL Management
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

    /**
     * Retrieves user's white list routes
     * @authenticated
     * @group ACL Management
     * @urlParam id required number the user's id
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend
     * @response {"success":true,"code":200,"locale":"en","message":"",
     * "data":[
     *  'route0 details',
     *  'route1 details',
     * ]}
     */
    public function whiteRoutes() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return $this->withData($user->whiteRoutes);
        }
        return $this->error(404);
    }

    /**
     * Retrieves user's black list routes
     * @authenticated
     * @group ACL Management
     * @urlParam id required number the user's id
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend
     * @response {"success":true,"code":200,"locale":"en","message":"",
     * "data":[
     *  'route0 details',
     *  'route1 details',
     * ]}
     */
    public function blackRoutes() {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return $this->withData($user->blackRoutes);
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
