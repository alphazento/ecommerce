<?php
namespace Zento\SalesAdmin\Model\Filters;

class MixFilter
{
    public function created_at() {
        return function($dates) {
            if ($date = ($dates[0] ?? false)) {
                $this->builder->where('created_at', '>=', $date);
            }
            if ($date = ($dates[1] ?? false)) {
                $this->builder->where('created_at', '<=', $date);
            }
            return $this->builder;
        };
    }

}