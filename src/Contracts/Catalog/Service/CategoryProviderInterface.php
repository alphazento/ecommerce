<?php

namespace Zento\Contracts\Catalog\Service;

interface CategoryProviderInterface
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getCategoryById($id);

    // /**
    //  * Retrieve a user by their unique identifier and "remember me" token.
    //  *
    //  * @param  mixed   $identifier
    //  * @return \Illuminate\Contracts\Auth\Authenticatable|null
    //  */
    // public function getCategoryByName($name);

    // /**
    //  * Retrieve a user by their unique identifier.
    //  *
    //  * @param  mixed  $identifier
    //  * @return \Illuminate\Contracts\Auth\Authenticatable|null
    //  */
    // public function getCategoryByIds($id);

    // /**
    //  * Retrieve a user by their unique identifier and "remember me" token.
    //  *
    //  * @param  mixed   $identifier
    //  * @return \Illuminate\Contracts\Auth\Authenticatable|null
    //  */
    // public function getCategoryByNames($name);

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function root();
}
