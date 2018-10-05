<?php

namespace Zento\CMS\Model\ORM;

use Illuminate\Support\Collection;

class Layout extends \Illuminate\Database\Eloquent\Model
{
    protected $connection = 'opencart';
    protected $table = 'oc_layout';
    protected $primaryKey = 'layout_id';

    public function modules() {
        return $this->hasMany(LayoutModule::class, 'layout_id')->orderBy('sort_order');
    }
}