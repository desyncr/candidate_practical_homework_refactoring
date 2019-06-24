<?php

namespace Docler\Language\Backend;

/**
 * Class implements a backend for the language generator.
 */
abstract class AbstractBackend implements BackendInterface
{
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
    abstract public function put($key, $value) : int;
    /**
     * Get the value under key $key.
     *
     * @param string $key   Key to save value under.
     *
     * @return string|null The value under key $key if found.
     */
    abstract public function get($key) : ?string;
    /**
     * Determine if the key $key exists.
     *
     * @param string $key   Key to check for.
     *
     * @return bool True if the key exists, false otherwise.
     */
    abstract public function exists($key) : bool;
    /**
     * Removes a key from the backend.
     *
     * @param string $key Key to remove.
     *
     * @return bool True no error ocurred.
     */
    abstract public function remove($key) : bool;

}
