<?php

namespace Zento\Acl\Model\ORM;

class AclBaseModel extends \Illuminate\Database\Eloquent\Model
{
    protected $connection = \Zento\Acl\Consts::DB;
}
