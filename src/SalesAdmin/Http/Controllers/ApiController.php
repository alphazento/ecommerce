<?php

namespace Zento\SalesAdmin\Http\Controllers;


use Route;
use Request;
use Registry;

use Zento\SalesAdmin\Model\ORM\SalesOrder;
use Zento\SalesAdmin\Model\ORM\AdminComment;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\SalesAdmin\Model\Filters\SalesOrderFilter;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiController extends ApiBaseController
{
    public function __construct() {
      parent::__construct();
    }

    /**
     * fetch/filter sales orders
     * @group Admin Sales
     */
    function getOrders(SalesOrderFilter $filters) {
      $filters->mixin(new \Zento\SalesAdmin\Model\Filters\MixFilter);
      $orders = SalesOrder::filter($filters)->paginate();
      return $this->withData($orders);
    }

    /**
     * Retrieves an order by id
     * @group Admin Sales
     * @urlParam id required number order id
     */
    function getOrder() {
      $order = SalesOrder::where('id', Route::input('id'))->first();
      return $this->withData($orders);
    }

    /**
     * update an order's status
     * @group Admin Sales
     * @urlParam id required number order id
     * @urlParam status_id required number order's new status' id
     * @bodyParam comment number comment
     */
    function setOrderStatus() {
      if ($order = SalesOrder::where('id', Route::input('id'))->first()) {
        $status_id = Route::input('status_id');
        if ($status_id !== null) {
          if ($order->status_id != $status_id) {
            if ($comment = Request::get('comment', false)) {
              $notify = Request::get('notify', false);
              $item = AdminComment::create([
                'type_id' => AdminComment::ORDER_STATUS_CHANGE,
                'admin_id' => 0,
                'order_id' => $order->id,
                'comment' => $comment,
                'notify_to_customer' => $notify
              ]);
            }
            $order->status_id = $status_id;
            $order->save();
          }
          return $this;;
        }
      }
      return $this->error(422, 'Not able to update order status');
    }

    /**
     * add an admin note
     * @group Admin Sales
     */
    function addAdminNote() {
      $order_id = Request::get('order_id');
      $comment = Request::get('comment');
      $notify = Request::get('notify');
      $item = AdminComment::create([
        'type_id' => AdminComment::ADMIN_NOTE,
        'admin_id' => 0,
        'order_id' => $order_id,
        'comment' => $comment,
        'notify_to_customer' => $notify
      ]);
      return $this->withData($item);
    }

    /**
     * @group Admin Sales
     */
    function getOrderStatuses() {

    }

    /**
     * @group Admin Sales
     */
    function holdOrder() {

    }

    /**
     * @group Admin Sales
     */
    function unholdOrder() {

    }

    /**
     * @group Admin Sales
     */
    function getComments(){

    }

    /**
     * @group Admin Sales
     */
    function setComments() {}
}
