<?php

namespace Docler\Language\Backend;

abstract class AbstractBackend implements BackendInterface
{
    abstract public function put($key, $value) : int;
    abstract public function get($key) : ?string;
    abstract public function exists($key) : bool;
    abstract public function remove($key) : bool;
}
