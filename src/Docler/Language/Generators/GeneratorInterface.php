<?php

namespace Docler\Language\Generators;

use Docler\Config\ConfigInterface;
use Docler\Api\ApiClientInterface;
use Docler\Language\Backend\BackendInterface;

/**
 * Interface to implement a language generator.
 */
interface GeneratorInterface
{
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
    );

    /**
     * Returns the available languages.
     *
     * @param string $target The target applet or application.
     *
     * @returns array
     */
    public function getLanguages($target) : array;

    /**
     * Generate the language files for the given target.
     *
     * @param string $target The target applet or application.
     * @param string $lang   The language to generate the files for.
     *
     * @returns bool
     */
    public function generate($target, $lang) : bool;
}
