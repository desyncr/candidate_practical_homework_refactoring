<?php

namespace Docler\Language\Backend;

class Filesystem extends AbstractBackend
{
    const DEFAULT_PERMS = 0755;

    public function put($key, $value) : int
    {
        if (!is_dir(dirname($key))) {
            mkdir(dirname($key), self::DEFAULT_PERMS, true);
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
