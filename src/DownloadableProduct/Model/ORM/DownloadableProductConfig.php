<?php

namespace Zento\DownloadableProduct\Model\ORM;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\ORM\Product as SimpleProduct;

class DownloadableProductConfig extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'product_id', 
        'quantitative', 
        'downloadable', 
        'download_url'
    ];
}