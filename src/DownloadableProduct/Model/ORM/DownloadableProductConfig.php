<?php

namespace Zento\DownloadableProduct\Model\ORM;

class DownloadableProductConfig extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'product_id',
        'quantitative',
        'downloadable',
        'download_url',
    ];
}
