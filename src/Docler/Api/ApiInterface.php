<?php

namespace Docler\Api;

interface ApiInterface
{
    public static function call($target, $mode, $getParameters, $postParameters);
}
