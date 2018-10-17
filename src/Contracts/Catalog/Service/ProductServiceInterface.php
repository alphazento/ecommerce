<?php

namespace Zento\Contracts\Catalog\Service;

interface ProductServiceInterface
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Zento\Contracts\Catalog\Model\Product|null
     */
    public function getProductById($id);

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed   $identifier
     * @return \Zento\Contracts\Catalog\Model\Product|null
     */
    public function getProductBySku($sku);


    /**
     * Retrieve products by their unique identifiers.
     *
     * @param  array  $identifiers
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getProductsByIds(array $ids);

    /**
     * Retrieve products by their unique skus.
     *
     * @param  array  $identifiers
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getProductsBySkus($sku);

    /**
     * get latest products(new product)
     *
     * @param integer $limit
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getLatestProducts($limit);

   /**
     * get popular products(new product)
     *
     * @param integer $limit
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getPopularProducts($limit);

    /**
     * @param integer $limit
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getBestSellerProducts($limit);
}
