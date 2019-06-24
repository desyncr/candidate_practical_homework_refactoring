<?php

namespace Docler\Language\Backend;

class Memory extends AbstractBackend
{
    private $data = [];

    public function put($key, $value) : int
    {
        $this->data[$key] = "$value";

        return strlen("$value");
    }

    public function get($key, $default = null) : ?string
    {
        if ($this->exists($key))
        {
            return $this->data[$key];
        }

        return false;
    }

    public function exists($key) : bool
    {
        return array_key_exists($key, $this->data);
    }

    public function remove($key) : bool
    {
        if ($this->exists($key))
        {
            unset($this->data[$key]);
        }

        return true;
    }
}
