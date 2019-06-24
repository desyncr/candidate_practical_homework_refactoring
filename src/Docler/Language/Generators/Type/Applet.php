<?php

namespace Docler\Language\Generators\Type;

use Docler\Api\ApiClient;
use Docler\Language\Generators\AbstractGenerator;

class Applet extends AbstractGenerator
{
    public function getLanguages($target) : array
    {
        $response = $this->api->get($target, null, ApiClient::GENERATOR_TYPE_APPLET);

        return $response['data'];
    }

    public function generate($target, $lang) : bool
    {
        $content = $this->api->get($target, $lang, ApiClient::GENERATOR_TYPE_APPLET_CONTENT);

        $dest = sprintf(
            '%s/%s/lang_%s.xml',
            $this->config::get('system.paths.root'),
            'cache/flash',
            $lang
        );

        return (bool)$this->backend->put($dest, $content['data']);
    }
}
