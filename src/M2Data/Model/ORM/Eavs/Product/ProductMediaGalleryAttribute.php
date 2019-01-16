<?php

namespace Zento\M2Data\Model\ORM\Eavs\Product;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ProductMediaGalleryAttribute extends \Zento\M2Data\Model\ORM\Eavs\AttrBase
{
    protected $table = 'catalog_product_entity_media_gallery';

    public function galleryvalue() {
        return $this->hasOne(MediaGallery\Value::class, 'value_id', 'value_id');
    }

    public function video() {
        return $this->hasOne(MediaGallery\ValueVideo::class, 'value_id', 'value_id');
    }

    public function getValueAttribute($value) {
        if (empty($this->galleryvalue)) {
            return '{}';
        }
        $values = ['type' => $this->media_type, 'value'=>$this->attributes['value']];
        switch($this->media_type) {
            case 'image':
                $values['label'] = $this->galleryvalue->label;
                break;
            case 'video':
                $values['video'] = $this->video ? $this->video->toArray() : null;
                break;
        }
        return json_encode($values);
    }

    public function getDisabledAttribute($value) {
        if (empty($this->galleryvalue)) {
            return 0;
        }
        return $this->galleryvalue->disabled;
    }

    public function getSortAttribute($value) {
        if (empty($this->galleryvalue)) {
            return 0;
        }
        return $this->galleryvalue->position;
    }
}