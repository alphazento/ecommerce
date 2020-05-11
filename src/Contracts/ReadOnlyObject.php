<?php

namespace Zento\Contracts;

use ArrayAccess;
use ArrayIterator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use IteratorAggregate;
use \Illuminate\Database\Eloquent\JsonEncodingException;

class ReadOnlyObject implements ArrayAccess, Arrayable, Jsonable, IteratorAggregate
{
    protected $attrs;

    public function __construct(array $attrs)
    {
        $this->attrs = [];
        foreach ($attrs as $key => $value) {
            if (is_array($value)) {
                $this->attrs[$key] = new static($value);
            } else {
                $this->attrs[$key] = $value;
            }
        }
    }

    public function __get($key)
    {
        return array_key_exists($key, $this->attrs) ? $this->attrs[$key] : null;
    }

    public function __set($key, $value)
    {
        throw new \Exception("This model is read only");
    }

    public function toArray()
    {
        $attrs = [];
        foreach ($this->attrs as $key => $value) {
            if ($value instanceof static ) {
                $attrs[$key] = $value->toArray();
            } else {
                $attrs[$key] = $value;
            }
        }
        return $attrs;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->attrs);
    }

    public function getAttributes()
    {
        return $this->attrs;
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param  int  $options
     * @return string
     *
     * @throws \Illuminate\Database\Eloquent\JsonEncodingException
     */
    public function toJson($options = 0)
    {
        $json = json_encode($this->toArray(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->attrs);
    }

    public function offsetGet($offset)
    {
        return array_key_exists($offset, $this->attrs) ? $this->attrs[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        throw new \Exception("This model is read only");
    }

    public function offsetUnset($offset)
    {
        throw new \Exception("This model is read only");
    }
}
