<?php

namespace Docler\Language\Generators\Type;

use Docler\Api\ApiClient;
use Docler\Language\Generators\AbstractGenerator;

/**
 * Class to generate Language files.
 */
class Language extends AbstractGenerator
{
    /**
     * Returns the available languages.
     *
     * @param string $target The target applet or application.
     *
     * @returns array
     */
    public function getLanguages($target) : array
    {
        $response = $this->api->get($target, null, ApiClient::GENERATOR_TYPE_LANG);

        return $response['data'];
    }

    /**
     * Generate the language files for the given target.
     *
     * @param string $target The target applet or application.
     * @param string $lang   The language to generate the files for.
     *
     * @returns bool
     */
    public function generate($target, $lang) : bool
    {
        $content = $this->api->get($target, $lang, ApiClient::GENERATOR_TYPE_LANG_CONTENT);

        $dest = sprintf(
            '%s/%s/%s/%s.php',
            $this->config::get('system.paths.root'),
            'cache',
            $target,
            $lang
        );

        return (bool)$this->backend->put($dest, $content['data']);
    }
}
