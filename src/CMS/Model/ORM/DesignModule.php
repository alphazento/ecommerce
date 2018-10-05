<?php

namespace Zento\CMS\Model\ORM;

use Illuminate\Support\Collection;

class DesignModule extends \Illuminate\Database\Eloquent\Model
{
    protected $connection = 'opencart';
    protected $table = 'oc_module';
    protected $primaryKey = 'module_id';
}