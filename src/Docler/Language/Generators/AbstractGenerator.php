<?php

namespace Docler\Language\Generators;

use Docler\Config\ConfigInterface;
use Docler\Api\ApiClientInterface;
use Docler\Language\Backend\BackendInterface;

abstract class AbstractGenerator implements GeneratorInterface
{
    /** @var BackendInterface */
    protected $backend;

    /** @var ConfigInterface */
    protected $config;

    /** @var ApiInterface */
    protected $api;

    public function __construct(
        BackendInterface $backend,
        ApiClientInterface $api,
        ConfigInterface $config
    )
    {
        $this->backend = $backend;
        $this->api     = $api;
        $this->config = $config;
    }

    abstract public function getLanguages($target) : array;

    abstract public function generate($target, $lang) : bool;
}
