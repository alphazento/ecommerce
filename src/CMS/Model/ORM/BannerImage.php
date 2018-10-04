<?php

namespace Zento\CMS\Model\ORM;

use Illuminate\Support\Collection;

class BannerImage extends \Illuminate\Database\Eloquent\Model
{
    protected $connection = 'opencart';
    protected $table = 'oc_banner_image';
    protected $primaryKey = 'banner_image_id';
}