<?php

namespace Zento\ElasticSuit\Elasticsearch\Schema;

use Closure;
use RuntimeException;
use BadMethodCallException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Support\Collection;

//Elasticsearch\Namespaces/IndicesNamespace

class Builder extends \Illuminate\Database\Schema\Builder
{
     /**
     * Create a new database Schema manager.
     *
     * @param  \Illuminate\Database\Connection  $connection
     * @return void
     */
    public function __construct(\Zento\ElasticSuit\Elasticsearch\Connection $connection)
    {
        $this->connection = $connection;
    }

    public function hasTable($table) {
        return $this->connection->elsAdapter()->indices()->exists([]);
    }

    public function table($table, Closure $callback) {

    }

    public function create($table, Closure $callback) {
        return $this->connection->elsAdapter()->indices()->putMapping([
            'index' => 'db',
            'type' => 'testModel',
            'include_type_name' => true,
            'body' => []
        ]);
    }

    public function drop($table) {
        $this->connection->elsAdapter()->indices()->deleteMapping();
    }
}