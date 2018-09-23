<?php

namespace Zento\M2Data\Model\ORM\Eavs;

use Zento\M2Data\Model\ORM\EavAttribute;

class AttrBase  extends \Illuminate\Database\Eloquent\Model
{
    protected $primaryKey = 'value_id';
    public function codedesc() {
        return $this->belongsTo(EavAttribute::class, 'attribute_id', 'attribute_id');
    }
}