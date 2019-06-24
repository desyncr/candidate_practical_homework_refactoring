<?php

namespace Docler\Language\Backend;

class Filesystem extends AbstractBackend
{
    public function put($key, $value) : int
    {
        // If there is no folder yet, we'll create it.
        var_dump($key);
        if (!is_dir(dirname($key))) {
            mkdir(dirname($key), 0755, true);
        }

        return file_put_contents($key, $value);
    }

    public function get($key) : ?string
    {
        if (file_exists($key)) {
            return file_get_contents($key);
        }

        return null;
    }

    public function exists($key) : bool
    {
        return file_exists($key);
    }

    public function remove($key) : bool
    {
        return unlink($key);
    }
}
