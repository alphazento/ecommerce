<?php

namespace Zento\Acl\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Validator;
use Request;
use Route;
use Zento\Acl\Model\ORM\AclBlackList;
use Zento\Acl\Model\ORM\AclRole;
use Zento\Acl\Model\ORM\AclRoleUser;
use Zento\Acl\Model\ORM\AclRoute;
use Zento\Acl\Model\ORM\AclWhiteList;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class AclUserController extends ApiBaseController
{
    use TraitHelper;

    /**
     * Retrieves user details
     * @authenticated
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend. Example:administrator
     * @urlParam id required number user's id Example:1
     * @responseModel \Zento\Acl\Model\Auth\Administrator
     */
    public function user()
    {
        if ($id = Route::input('id')) {
            $model = $this->getUserModel();
            if ($user = $model::find($id)) {
                return $this->withData($user);
            }
        }
        return $this->error(404);
    }

    /**
     * Retrieves all administrator/customers(accept filter)
     * @authenticated
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend. Example:administrator
     * @queryParam id user's id filter
     * @queryParam firstname user's firstname filter
     * @queryParam lastname user's lastname filter
     * @queryParam email user's email filter
     * @queryParam active user's active filter
     * @queryParam page pagination filter
     * @responseCollectionPagination \Zento\Acl\Model\Auth\Administrator
     */
    public function users()
    {
        $model = $this->getUserModel();
        $collection = $model::select('*');
        return $this->withData($this->applyFilter($collection, ['id', 'firstname', 'lastname', 'email', 'active'])->paginate());
    }

    /**
     * create a new user
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend. Example:administrator
     * @bodyParam email string required
     * @bodyParam name string required
     * @bodyParam password string required
     * @responseModel 201 \Zento\Acl\Model\Auth\Administrator
     */
    public function store()
    {
        $data = Request::only('email', 'name', 'password');
        $validator = Validator::make($data, [
            'email' => 'required|max:255|email',
            'name' => 'required|max:255',
            'password' => 'required|max:16|min:8',
            'confirm_password' => 'required|max:16|min:8',
        ]);

        if ($validator->fails()) {
            return $this->error(400, json_encode($validator->errors()));
        }

        $password = Request::get('password', '');
        if ($password != Request::get('confirm_password', '')) {
            return $this->error(400, 'password and confirm password not match.');
        }

        $model = $this->getUserModel();
        if ($model::where('email', $data['email'])->exists()) {
            return $this->error(400, $data['email'] . ' has exists');
        }
        if (!empty($password)) {
            $user->password = $user->encryptPassword($password);
        }

        $user->save();
        return $this->withData($user);
    }

    /**
     * update user's details
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend. Example:administrator
     * @urlParam id required number user's id
     * @responseModel 200 \Zento\Acl\Model\Auth\Administrator
     * @responseError 400
     */
    public function update()
    {
        $id = Route::input('id');
        $params = Request::get('data');
        $model = $this->getUserModel();
        if ($user = $model::find($id)) {
            foreach ($params as $key => $value) {
                switch ($key) {
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
        return $this->error(400)->withData($params);
    }

    /**
     * set config key value pair by input key value pair items
     * @authenticated
     * @group ACL Management
     * @urlParam id number required user id to delete
     */
    public function delete()
    {
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
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend. Example:administrator
     * @urlParam id required number the user's id Example:1
     * @responseCollection \Zento\Acl\Model\ORM\AclWhiteList
     */
    public function whiteRoutes()
    {
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
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend. Example:administrator
     * @urlParam id required number the user's id Example:1
     * @responseCollection \Zento\Acl\Model\ORM\AclBlackList
     */
    public function blackRoutes()
    {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return $this->withData($user->blackRoutes);
        }
        return $this->error(404);
    }

    /**
     * add route to user's white list
     * @group ACL Management
     * @urlParam id required number user's id
     * @bodyParam route_ids required number routes' ids
     */
    public function storeWhiteRoutes()
    {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            if ($route_ids = Request::get('route_ids')) {
                $route_ids = AclRoute::whereIn('id', $route_ids)->pluck('id')->toArray();
                $exists = AclWhiteList::where('user_id', $user->id)->whereIn('route_id', $route_ids)->pluck('route_id')->toArray();
                $route_ids = array_diff($route_ids, $exists);
                foreach ($route_ids as $id) {
                    AclWhiteList::create(['user_id' => $user->id, 'route_id' => $id]);
                }
                AclBlackList::where('user_id', $user->id)->whereIn('route_id', $route_ids)->delete();
                return $this->success(201);
            }
            return $this->success();
        }
        return $this->error(404);
    }

    /**
     * add route to user's black list
     * @group ACL Management
     * @urlParam id required number user's id
     * @bodyParam route_ids required number routes' ids
     */
    public function storeBlackRoutes()
    {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $ids = AclRoute::whereIn('id', $ids)->pluck('id')->toArray();
                $exists = AclBlackList::where('user_id', $user->id)->whereIn('route_id', $ids)->pluck('route_id')->toArray();
                $route_ids = array_diff($ids, $exists);
                foreach ($route_ids as $id) {
                    AclBlackList::create(['user_id' => $user->id, 'route_id' => $id]);
                }
                AclWhiteList::where('user_id', $user->id)->whereIn('route_id', $route_ids)->delete();
                return $this->success(201);
            }
            return $this->success();
        }
        return $this->error(404);
    }

    /**
     * delete route from user's white list
     * @group ACL Management
     * @urlParam id required number user's id
     * @bodyParam route_ids required number routes' ids
     */
    public function deleteWhiteRoute()
    {
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

    /**
     * delete route from user's black list
     * @group ACL Management
     * @urlParam id required number user's id
     * @bodyParam route_ids required number routes' ids
     */
    public function deleteBlackRoute()
    {
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

    /**
     * Retrieves user's all roles
     * @group ACL Management
     * @urlParam id required number user's id
     */
    public function roles()
    {
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            return $this->withData($user->roles);
        }
        return $this->error(404);
    }

    /**
     * save user's roles
     * @group ACL Management
     * @urlParam id required number user's id
     * @bodyParam ids required array role's ids
     */
    public function storeRoles()
    {
        $error = '';
        $model = $this->getUserModel();
        if ($user = $model::find(Route::input('id'))) {
            if ($ids = Request::get('ids')) {
                $gids = AclRole::where('scope', $this->getScope())->whereIn('id', $ids)->pluck('id')->toArray();
                foreach ($gids as $gid) {
                    AclRoleUser::create([
                        'scope' => $this->getScope(),
                        'user_id' => $user->id, 'group_id' => $gid]);
                }
                return $this->success(201);
            }
        } else {
            $error = 'User not found';
        }
        return $this->error(400, $error);
    }
}
