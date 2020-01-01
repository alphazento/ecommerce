<?php
namespace Zento\SalesAdmin\Model\Filters;

use Zento\Customer\Model\ORM\Customer;
use Zento\Kernel\Booster\Database\Eloquent\QueryFilter;

class SalesOrderFilter extends QueryFilter
{
    public function id($id)
    {
        return $this->builder->where('id', '=', $id);
    }

    public function order_number($order_number)
    {
        return $this->builder->where('order_number', 'like', "%{$order_number}%");
    }

    public function status_id($status_id) {
        return $this->builder->where('status_id', '=', $status_id);
    }

    public function created_at($dates) {
        if ($date = ($dates[0] ?? false)) {
            $this->builder->where('created_at', '>=', $date);
        }
        if ($date = ($dates[1] ?? false)) {
            $this->builder->where('created_at', '<=', $date);
        }
        return $this->builder;
    }

    public function customer($email) {
        if ($email) {
            return $this->builder->whereIn('customer_id', function($query) use($email) {
                $query->select('id')
                    ->from(with(new Customer)->getTable())
                    ->where('email', 'like', "%{$email}%");
            }); 
        }
    }
}