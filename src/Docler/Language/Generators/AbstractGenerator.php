<?php

namespace Docler\Language\Generators;

use Docler\Config\ConfigInterface;
use Docler\Api\ApiClientInterface;
use Docler\Language\Backend\BackendInterface;

/**
 * Class to generate Language or applet language files.
 */
abstract class AbstractGenerator implements GeneratorInterface
{
    /** @var BackendInterface */
    protected $backend;

    /** @var ConfigInterface */
    protected $config;

    /** @var ApiInterface */
    protected $api;

    /**
     * Constructor
     *
     * @param BackendInterface   $backend A given backend to persist
     * @param ApiClientInterface $api     An API client interface
     * @param ConfigInterface    $config  A config interface
     */
    public function __construct(
        BackendInterface $backend,
        ApiClientInterface $api,
        ConfigInterface $config
    ) {
        $this->backend = $backend;
        $this->api     = $api;
        $this->config = $config;
    }

    /**
     * Returns the available languages.
     *
     * @param string $target The target applet or application.
     *
     * @returns array
     */
    abstract public function getLanguages($target) : array;

    /**
     * Generate the language files for the given target.
     *
     * @param string $target The target applet or application.
     * @param string $lang   The language to generate the files for.
     *
     * @returns bool
     */
    abstract public function generate($target, $lang) : bool;
}
