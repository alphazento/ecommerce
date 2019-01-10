<?php

namespace Zento\Contracts;

use ArrayAccess;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use \Illuminate\Database\Eloquent\JsonEncodingException;

class ReadOnlyObject implements ArrayAccess, Arrayable, Jsonable
{
    protected $attrs;

    public function __construct(array $attrs) {
        $this->attrs = $attrs;
    }

    public function __get($key) {
        return isset($this->attrs[$key]) ? $this->attrs[$key] : null;
    }

    public function __set($key, $value) {
        throw new \Exception("This model is read only");
    }

    public function toArray() {
        return $this->attrs;
    }

    public function getAttributes() {
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
        return isset($this->attrs[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->attrs[$offset]) ? $this->attrs[$offset] : null;
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