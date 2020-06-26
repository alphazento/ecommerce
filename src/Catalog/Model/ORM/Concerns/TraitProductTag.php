<?php

namespace Zento\Catalog\Model\ORM\Concerns;

use Zento\CatalogTag\Model\ORM\ProductTagLink;
use Zento\CatalogTag\Model\ORM\Tag;

trait TraitProductTag
{
    public function tags()
    {
        return $this->belongsToMany(Tag::class,
            ProductTagLink::class,
            'product_id', 'tag_id');
    }

    /**
     * Apply tags filter.
     *
     * @param $filters array. should be a Request query array parsed by Tag::parseTagQuery()
     */
    public function scopeTags($query, array $filters = [])
    {
        if ($filters && count($filters) > 0) {
            foreach ($filters as $group => $values) {
                $query->whereHas('tags', function ($q) use ($group, $values) {
                    return $q->where('model_type', $group)
                        ->whereIn('name', $values);
                });
            }
        }
        return $query;
    }

    /**
     * Apply tags filter.
     *
     * @param $filters array. should be a Request query array parsed by Tag::parseTagQuery()
     */
    public function scopeTagGroups($query, array $filters = [])
    {
        if ($filters && count($filters) > 0) {
            foreach ($filters as $group => $values) {
                $query->whereHas('tags', function ($q) use ($group) {
                    return $q->where('model_type', $group);
                });
            }
        }
        return $query;
    }
}
