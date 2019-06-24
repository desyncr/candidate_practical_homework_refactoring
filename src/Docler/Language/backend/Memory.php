<?php

namespace Docler\Language\Backend;

/**
 * Class implements an in-memory backend for the language generator.
 */
class Memory extends AbstractBackend
{
    private $data = [];

    /**
     * Persist the value $value under key $key.
     *
     * If the key exists the value will be overwrite.
     *
     * @param string $key   Key to save value under.
     * @param any    $value Value to store.
     *
     * @return int   Bytes saved.
     */
    public function put($key, $value) : int
    {
        $this->data[$key] = "$value";

        return strlen("$value");
    }

    /**
     * Get the value under key $key.
     *
     * @param string $key   Key to save value under.
     *
     * @return string|null The value under key $key if found.
     */
    public function get($key, $default = null) : ?string
    {
        if ($this->exists($key)) {
            return $this->data[$key];
        }

        return false;
    }

    /**
     * Determine if the key $key exists.
     *
     * @param string $key   Key to check for.
     *
     * @return bool True if the key exists, false otherwise.
     */
    public function exists($key) : bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Removes a key from the backend.
     *
     * @param string $key Key to remove.
     *
     * @return bool True no error ocurred.
     */
    public function remove($key) : bool
    {
        if ($this->exists($key)) {
            unset($this->data[$key]);
        }

        return true;
    }
}
