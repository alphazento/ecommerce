<?php

namespace Zento\Catalog\Services;

use Zento\Catalog\Model\DB\Category;
use Zento\Catalog\Model\DB\Category\Description;
use DB;

class EloquentCategoryProvider implements \Zento\Contracts\Catalog\CategoryProvider {
    protected $model;

    /**
     * Create a new database user provider.
     *
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  string  $model
     * @return void
     */
    public function __construct(HasherContract $hasher, $model)
    {
        $this->model = $model;
        $this->hasher = $hasher;
    }
    
    public function __call($method, $argv) {
    }

  
     /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $model = $this->createModel();

        return $model->newQuery()
            ->where($model->getCategoryIdentifierName(), $identifier)
            ->first();
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed   $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByName($name) {
        $model = $this->createModel();

        return $model->newQuery()
            ->where($model->getCategoryIdentifierName(), $identifier)
            ->first();
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function tree();
}