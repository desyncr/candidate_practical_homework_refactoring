<?php

namespace Docler\Language\Generators;

use Docler\Config\ConfigInterface;
use Docler\Api\ApiClientInterface;
use Docler\Language\Backend\BackendInterface;

interface GeneratorInterface
{
    public function __construct(
        BackendInterface $backend,
        ApiClientInterface $api,
        ConfigInterface $config
    );

    public function getLanguages($target) : array;
    public function generate($target, $lang) : bool;
}
