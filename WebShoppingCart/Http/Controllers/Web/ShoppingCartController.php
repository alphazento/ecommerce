<?php

namespace Zento\WebShoppingCart\Http\Controllers\Web;


use Auth;
use Route;
use Request;
use Response;
use Registry;
use Zento\ShoppingCart\Providers\Facades\ShoppingCartService;
use Zento\Catalog\Providers\Facades\ProductService;

use Zento\ShoppingCart\Model\ORM\ShoppingCart;
use Zento\ShoppingCart\Model\ORM\ShoppingCartAddress;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShoppingCartController extends \App\Http\Controllers\Controller
{
    public function cartPage() {
        return view('page.shoppingcart');
    }

    public function getCart() {
    }

    public function addItem() {
    }

    public function updateItemQuantity() {
    }

    public function deleteItem() {
    }

    public function updateItem() {
    }

    public function putCoupon() {
    }

    public function getCoupon() {
    }

    public function deleteCoupon() {
    }

    public function setBillingAddress() {
        
    }

    public function getBillingAddress() {

    }

    public function setShippingAddress() {

    }

    public function getShippingAddress() {

    }

    public function mergeCart() {
        
    }

    public function getCustomer() {

    }

    public function setCustomer() {
        
    }

    public function updateEmail() {
       
    }
}