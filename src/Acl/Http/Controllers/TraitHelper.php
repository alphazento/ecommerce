<?php

namespace Zento\Acl\Http\Controllers;

use Route;
use Request;
use Zento\Acl\Consts;
use Zento\Acl\Model\Auth\Customer;
use Zento\Acl\Model\Auth\Administrator;

trait TraitHelper
{
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
                return Consts::BACKEND_SCOPE;
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
                return [Consts::BACKEND_SCOPE, Consts::BOTH_SCOPE];
            case 'customer':
                return [Consts::FRONTEND_SCOPE, Consts::BOTH_SCOPE];
            case 'all':
                return [Consts::GUEST_SCOPE, Consts::FRONTEND_SCOPE, Consts::BACKEND_SCOPE, Consts::BOTH_SCOPE];
            default:
                return [\Zento\Acl\Consts::GUEST_SCOPE];
        }
        return [\Zento\Acl\Consts::GUEST_SCOPE];
    }

    protected function applyFilter($collection, $filterAbles) {
        $filters = Request::only($filterAbles);
        foreach($filters as $field => $value) {
            $collection->where($field, 'like', $value);
        }
        return $collection;
    }
}
