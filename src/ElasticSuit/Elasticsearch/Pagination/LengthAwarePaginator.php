<?php

namespace Zento\ElasticSuit\Elasticsearch\Pagination;

class LengthAwarePaginator extends \Illuminate\Pagination\LengthAwarePaginator {
    protected $aggregate;

    public function __construct($items, $total, $perPage, $currentPage = null, array $options = [])
    {
        foreach ($options as $key => $value) {
            $this->{$key} = $value;
        }

        parent::__construct($items, $total, $perPage, $currentPage);
    }

    public function toArray()
    {
        return [
            'current_page' => $this->currentPage(),
            'data' => $this->items->toArray(),
            'first_page_url' => $this->url(1),
            'from' => $this->firstItem(),
            'last_page' => $this->lastPage(),
            'last_page_url' => $this->url($this->lastPage()),
            'next_page_url' => $this->nextPageUrl(),
            'path' => $this->path,
            'per_page' => $this->perPage(),
            'prev_page_url' => $this->previousPageUrl(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
            'aggregate' => $this->aggregate,
        ];
    }
}