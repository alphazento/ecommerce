<?php

namespace Zento\Catalog\Model;

class ProductVisibility
{
    const NOT_VISIBLE_INDI = 1;
    const IN_CATALOG = 2;
    const IN_SEARCH = 3;
    const BOTH = 4;

    protected $visibilies = [
        self::NOT_VISIBLE_INDI => 'Not Visible Individually',
        self::IN_CATALOG => 'Catalog',
        self::IN_SEARCH => 'Search',
        self::BOTH => 'Catalog, Search',
    ];

    protected $valueMapping;

    public function __construct()
    {
        $this->valueMapping = array_flip($this->visibilies);
    }

    public function setValueMapping($valueMapping)
    {
        $this->valueMapping = array_merge($valueMapping, $this->valueMapping);
    }

    public function getIdByValue($value)
    {
        return isset($this->valueMapping[$value]) ? $this->valueMapping[$value] : 0;
    }

    public function toArray()
    {
        return $this->visibilies;
    }
}
