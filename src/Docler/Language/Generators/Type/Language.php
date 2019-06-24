<?php

namespace Docler\Language\Generators\Type;

use Docler\Api\ApiClient;
use Docler\Language\Generators\AbstractGenerator;

class Language extends AbstractGenerator
{
    public function getLanguages($target) : array
    {
        $response = $this->api->get($target, null, ApiClient::GENERATOR_TYPE_LANG);

        return $response['data'];
    }

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
