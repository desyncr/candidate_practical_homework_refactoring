<?php

namespace Docler\Language\Backend;

interface BackendInterface
{
    public function put($key, $value) : int;
    public function get($key) : ?string;
    public function exists($key) : bool;
    public function remove($key) : bool;
}
