<?php

namespace Zento\ElasticSuit\Elasticsearch\Schema;

class Blueprint extends \Illuminate\Database\Schema\Blueprint {
    /**
     * Create a new string column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function keyword($column)
    {
        return $this->addColumn('keyword', $column);
    }
}