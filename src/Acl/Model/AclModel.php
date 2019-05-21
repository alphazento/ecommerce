<?php

namespace Zento\Acl\Model;

class ApcModel extends \Illuminate\Database\Eloquent\Model
{
    protected $connection = \Zento\Acl\Consts::APC_DB;
}
