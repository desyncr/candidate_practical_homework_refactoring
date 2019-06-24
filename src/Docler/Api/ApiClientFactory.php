<?php
namespace Docler\Api;

use Docler\Api\ApiInterface;
use Docler\Api\ApiClientInterface;
use Docler\Api\ApiCall;
use Docler\Api\Exceptions\InvalidApiResponseException;

final class ApiClientFactory
{
    static public function create(ApiInterface $api = null) : ApiClientInterface
    {
        // No futher configuration required
        return new ApiClient($api ?? new ApiCall);
    }
}
