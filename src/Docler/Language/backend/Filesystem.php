<?php

namespace Docler\Language\Backend;

/**
 * Class implements a filesystem backend for the language generator.
 */
class Filesystem extends AbstractBackend
{
    const DEFAULT_PERMS = 0755;
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
        if (!is_dir(dirname($key))) {
            mkdir(dirname($key), self::DEFAULT_PERMS, true);
        }

        return file_put_contents($key, $value);
    }

    /**
     * Get the value under key $key.
     *
     * @param string $key   Key to save value under.
     *
     * @return string|null The value under key $key if found.
     */
    public function get($key) : ?string
    {
        if (file_exists($key)) {
            return file_get_contents($key);
        }

        return null;
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
        return file_exists($key);
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
        return unlink($key);
    }
}
