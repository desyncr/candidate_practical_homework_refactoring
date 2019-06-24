<?php
namespace Docler\Api;

use Docler\Api\ApiInterface;
use Docler\Api\ApiClientInterface;
use Docler\Api\ApiCall;
use Docler\Api\Exceptions\InvalidApiResponseException;

/**
 * Factory to create ApiClient
 */
final class ApiClientFactory
{
    /**
     * Returns an instance of an ApiClient
     *
     * @return ApiClientInterface
     */
    public static function create(ApiInterface $api = null) : ApiClientInterface
    {
        // No futher configuration required
        return new ApiClient($api ?? new ApiCall);
    }
}
