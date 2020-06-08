<?php

namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificOAuth extends ThinkificResource
{

    /**
     * Refreshes OAuth Token
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param string $client_id
     * @param string $client_secret
     * @param string $refresh_token
     * @return stdClass
     * @throws Exception
     */

    public function refresh($client_id, $client_secret, $refresh_token) {

        $headers = [
            'Authorization' => 'Basic '.base64_encode("$client_id:$client_secret")
        ];

        $uri = $this->client->uriFactory->createUri("https://".$this->client->domain.".thinkific.com/oauth2/token");

        $body = [
            'grant_type' => 'token',
            'refresh_token' => $refresh_token
        ];

        $request = $this->client->requestFactory->createRequest('POST', $uri, $headers, $body);

        $response = $this->client->httpClient->sendRequest($request);

        return $this->client->handleResponse($response);
    }
}
