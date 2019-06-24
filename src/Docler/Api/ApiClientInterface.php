<?php

namespace Docler\Api;

/**
 * Interface to implement an ApiClient
 */
interface ApiClientInterface
{
    /**
     * Gets a language xml for an application or applet.
     *
     * @param string $target    The identifier of the applet.
     * @param string $lang      The language identifier.
     * @param string $type      The generator type (applet, lang)
     *
     * @return string|false     The content of the language file or false if weren't able to get it.
     * @throws \Exception       Error getting content.
     */

    public function get($target, $lang, $type) : array;
}
