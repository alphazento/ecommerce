<?php

namespace Zento\Contracts\Catalog\Service;

interface ProductProviderInterface
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getProductById($id);

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed   $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getProductySku($sku);


    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  array  $identifiers
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getProductByIds(array $ids);

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  array   $skus
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getProductBySkus($sku);

    /**
     * get latest product(new product)
     *
     * @param nuberic $limit
     * @return void
     */
    public function getLatestProduct($limit);

    /**
     * @param nuberic $limit
     * @return void
     */
    public function getPopularProducts($limit);

    /**
     * @param nuberic $limit
     * @return void
     */
    public function getBestSellerProducts($limit);
}
