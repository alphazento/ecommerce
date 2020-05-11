<?php
namespace Zento\Catalog\Model;

use Illuminate\Database\Eloquent\Collection;

class HasManyInAggregatedField extends \Illuminate\Database\Eloquent\Relations\HasMany
{
    protected $aggregatedFieldHanler;

    public function whereInAggregatedField(\Closure $aggregatedFieldHanler)
    {
        $this->aggregatedFieldHanler = $aggregatedFieldHanler;
        return $this;
    }

    protected function handleAggregatedField($data)
    {
        if ($this->aggregatedFieldHanler) {
            return $this->aggregatedFieldHanler->call($this, $data);
        }
        return $data;
    }

    public function getResults()
    {
        $this->addEagerConstraints([$this->parent]);
        return $this->query->get();
    }

    public function addConstraints()
    {
        if (static::$constraints) {
            $this->query->whereNotNull($this->foreignKey);
        }
    }

    public function addEagerConstraints(array $models)
    {
        $data = [];
        $keys = $this->getKeys($models, $this->localKey);
        foreach ($keys as $key) {
            $data = array_merge($data, $this->handleAggregatedField($key));
        }

        $this->query->whereIn($this->foreignKey, array_unique(array_map('trim', $data)));
    }

    public function matchOneOrMany(array $models, Collection $results, $relation, $type)
    {
        $dictionary = $this->buildDictionary($results);
        foreach ($models as $model) {
            $keys = array_unique(array_map('trim', $this->handleAggregatedField($model->getAttribute($this->localKey))));
            $data = [];
            foreach ($keys as $key) {
                if (isset($dictionary[$key])) {
                    $data[] = $dictionary[$key][0];
                }
            }
            if (count($data)) {
                $model->setRelation($relation, $this->related->newCollection($data));
            }
        }
        return $models;
    }
}
