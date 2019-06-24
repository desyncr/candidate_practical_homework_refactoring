<?php

namespace Docler\Language\Generators;

use Docler\Config\Config;
use Docler\Api\ApiClientFactory;
use Docler\Language\Backend\Filesystem;
use Docler\Language\Generators\Language;
use Docler\Language\Generators\Applet;

/**
 * Factory to create language generators
 */
final class GeneratorFactory
{
    const GENERATOR_APPLET = 'applet';
    const GENERATOR_LANG = 'language';

    /**
     * Returns an instance of a language generator
     *
     * @return GeneratorInteface
     */
    public static function create($type) : GeneratorInterface
    {
        $backend = new Filesystem;
        $api     = ApiClientFactory::create();
        $config  = new Config;

        $klass = null;
        switch ($type) {
        case self::GENERATOR_APPLET:
            $klass = ucfirst($type);
            break;
        case self::GENERATOR_LANG:
            $klass = ucfirst($type);
            break;
        default:
            throw new \RunTimeException(
                sprintf('Invalid generator type provided: %s', $type)
            );
        }

        $klass = sprintf('\Docler\Language\Generators\Type\%s', $klass);
        return new $klass($backend, $api, $config);
    }
}
