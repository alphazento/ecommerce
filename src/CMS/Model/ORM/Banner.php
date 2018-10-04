<?php

namespace Zento\CMS\Model\ORM;

use Illuminate\Support\Collection;

class Banner extends \Illuminate\Database\Eloquent\Model
{
    protected $connection = 'opencart';
    protected $table = 'oc_banner';
    protected $primaryKey = 'banner_id';

    public function images() {
        return $this->hasMany(BannerImage::class, 'banner_id');
    }
}