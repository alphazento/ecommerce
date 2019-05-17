<?php

namespace Zento\ElasticSuit\Elasticsearch\Schema;

use Closure;
use RuntimeException;
use BadMethodCallException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Support\Collection;
use Illuminate\Database\Schema\Blueprint;

use Zento\Kernel\Facades\DanamicAttributeFactory;

//Elasticsearch\Namespaces/IndicesNamespace

class Builder extends \Illuminate\Database\Schema\Builder
{
    protected $ormModel;
    protected $blueprintCallback;
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
        return $this->connection->elsAdapter()->indices()->exists(['index' => $table]);
    }

    // public function table($table, Closure $callback) {
    // }

    public function fromOrmModel($className, \Closure $callback) {
        $this->ormModel = $className;
        $this->blueprintCallback = $callback;
        return $this;
    }

    protected function prepareFiledMapping($define) {
        $mapping = [];
        $define = is_array($define) ? $define : ['type' => $define];
        $type = $define['type'];
        switch($type) {
            case 'integer':
            case 'float':
            case 'double':
                $mapping['type'] = $type;
                break;
            case 'boolean':
                $mapping['type'] = 'byte';
                break;
            case 'timestamp':
                $mapping['type'] = 'date';
                $mapping['format'] = 'yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis';
                break;
            case 'string':
            case 'varchar':
            case 'text':
                $mapping = ['type' => 'text', 'fielddata' => true];
                break;
            default:
                $mapping = ['type' => 'text', 'fielddata' => true];
                break;
        }

        if ($define['fielddata'] ?? false) {
            $mapping['fielddata'] = true;
        }
        if ($define['keyword'] ?? false) {
            $mapping['fields'] = ['keyword' => ['type' => 'keyword']];
        }
        if (($define['index'] ?? false) && $mapping['type'] == 'string' && !is_bool($define['index'])) {
            $mapping['index'] = $define['index'];
            $mapping['fields']['raw'] = ['index' => 'not_analyzed', 'type' => 'string'];
        }
        
        return $mapping;
    }

    /**
     * Execute the blueprint to build / modify the table.
     *
     * @param  \Illuminate\Database\Schema\Blueprint  $blueprint
     * @return void
     */
    protected function build(Blueprint $blueprint)
    {
        if ($this->blueprintCallback) {
            $callback = $this->blueprintCallback;
            $callback($blueprint);
        }
        $columns = $blueprint->getColumns();
        $body = [];
        foreach($columns as $column) {
            $body[$column->name] =  $this->prepareFiledMapping($column->toArray());
        }

        if ($this->ormModel) {
            $attributes = DanamicAttributeFactory::getDynamicAttributes($this->ormModel, []);
            foreach($attributes as $attribute) {
                if (count($attribute['options']) > 0) {
                    $body[$attribute['attribute_name']] =  $this->prepareFiledMapping(['type' => 'string', 'keyword' => true]);
                } else {
                    $body[$attribute['attribute_name']] =  $this->prepareFiledMapping($attribute['attribute_type']);
                }
            }
        }

        try {
            $this->connection->elsAdapter()->indices()->create([
                'index' => $blueprint->getTable(),
                'body' => ['mappings' => ['properties' => $body]]
            ]);
        } catch (\Elasticsearch\Common\Exceptions\BadRequest400Exception $e) {
            if ($msg = json_decode($e->getMessage(), true)) {
            }

            if ($errType = $msg['error']['root_cause'][0]['type'] ?? false) {
                if ($errType !== 'resource_already_exists_exception') {
                    throw $e;
                }
            }
        } 
    }

    public function drop($table) {
        if ($this->hasTable($table)) {
            $this->connection->elsAdapter()->indices()->deleteMapping(
                [
                    'index' => $table,
                    'type' => '_doc'   
                ]);
        }
    }
}