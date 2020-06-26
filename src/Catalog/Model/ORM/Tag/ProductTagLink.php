<?php

namespace Zento\Catalog\Model\DB;

use Illuminate\Database\Eloquent\Model;

class ProductTagLink extends Model
{
    public function tag()
    {
        return $this->hasOne(Tag::class, 'id', 'tag_id');
    }
}
