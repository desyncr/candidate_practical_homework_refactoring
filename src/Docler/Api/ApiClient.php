<?php
namespace Docler\Api;

use Docler\Api\ApiInterface;
use Docler\Api\ApiClientInterface;
use Docler\Api\Exceptions\InvalidApiResponseException;

/**
 * Class is a wrapper over ApiCall class to provide functionallity
 * to easily pass arguments to the API.
 */
class ApiClient implements ApiClientInterface
{
    const API_RESPONSE_OK = 'OK';

    const GENERATOR_TYPE_LANG = 'lang';
    const GENERATOR_TYPE_LANG_CONTENT = 'lang-content';
    const GENERATOR_TYPE_APPLET = 'applet';
    const GENERATOR_TYPE_APPLET_CONTENT = 'applet-content';

    /** @var ApiInterface */
    protected $api;

    /**
     * @param ApiInterface $api Api to wrap
     */
    public function __construct(ApiInterface $api)
    {
        $this->api = $api;
    }

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
    public function get($target, $lang, $type) : array
    {
        $post_args = [
            'language' => $lang
        ];

        if ($type === self::GENERATOR_TYPE_APPLET)
        {
            $post_args['applet'] = $target;
        }

        $get_args = [
            'system' => 'LanguageFiles',
        ];

        switch ($type)
        {
        case self::GENERATOR_TYPE_APPLET:
            $get_args['action'] = 'getAppletLanguages';
            break;
        case self::GENERATOR_TYPE_LANG:
            $get_args['action'] = 'getLanguageFile';
            break;
        case self::GENERATOR_TYPE_APPLET_CONTENT:
            $get_args['action'] = 'getAppletLanguageFile';
            break;
        case self::GENERATOR_TYPE_LANG_CONTENT:
            $get_args['action'] = 'getLanguageFile';
            break;
        }

        $response = $this->api::call(
            'system_api',
            'language_api',
            $get_args,
            $post_args
        );

        try {

            $this->checkForApiErrorResult($response);

        } catch (\Exception $e) {
            throw new \Exception(
                sprintf(
                    'Error getting lang from API: %s, %s, %s: %s',
                    $target,
                    $lang,
                    $type,
                    $e->getMessage()
                )
            );
        }

        return $response;
    }

    /**
     * Checks the api call result.
     *
     * @param mixed  $result   The api call result to check.
     *
     * @throws InvalidApiResponseException If the api call was not successful.
     *
     * @return void
     */
    protected function checkForApiErrorResult($result)
    {
        // Error during the api call.
        if ($result === false || !isset($result['status'])) {
            throw new InvalidApiResponseException('Error during the api call');
        }

        // Wrong response.
        if ($result['status'] != self::API_RESPONSE_OK) {

            throw new \InvalidApiResponseException(
                sprintf(
                    'Wrong response: Type(%s) Code(%s) %s',
                    !empty($result['error_type']) ?? $result['error_type'],
                    !empty($result['error_code']) ?? $result['error_code'],
                    (string)$result['data']
                )
            );

        }
        // Wrong content.
        if ($result['data'] === false) {
            throw new InvalidApiResponseException('Wrong content!');
        }
    }
}
