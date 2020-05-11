<?php

namespace Zento\Acl\Http\Controllers;

use Request;
use Route;
use Zento\Acl\Consts;
use Zento\Acl\Model\Auth\Administrator;
use Zento\Acl\Model\Auth\Customer;

trait TraitHelper
{
    protected function getUserModel()
    {
        $scope = Route::input('scope');
        $model = '';
        switch ($scope) {
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

    protected function getScope()
    {
        $scope = Route::input('scope');
        switch ($scope) {
            case 'administrator':
                return Consts::BACKEND_SCOPE;
            case 'customer':
                return Consts::FRONTEND_SCOPE;
            case 'all':
                return Consts::BOTH_SCOPE;
        }
        return '';
    }

    protected function getScopes()
    {
        $scope = Route::input('scope');
        switch ($scope) {
            case 'administrator':
                return [Consts::BACKEND_SCOPE, Consts::BOTH_SCOPE];
            case 'customer':
                return [Consts::FRONTEND_SCOPE, Consts::BOTH_SCOPE];
        }
        return [];
    }

    protected function applyFilter($collection, $filterAbles)
    {
        $filters = Request::only($filterAbles);
        foreach ($filters as $field => $value) {
            $collection->where($field, 'like', $value);
        }
        return $collection;
    }
}
