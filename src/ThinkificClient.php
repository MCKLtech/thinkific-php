<?php

namespace Thinkific;

use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\RequestFactory;
use Http\Message\UriFactory;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use stdClass;

class ThinkificClient
{
    /**
     * @var HttpClient $httpClient
     */
    private $httpClient;

    /**
     * @var RequestFactory $requestFactory
     */
    private $requestFactory;

    /**
     * @var UriFactory $uriFactory
     */
    private $uriFactory;

    /**
     * @var string API Token
     */
    private $apiToken;

    /**
     * @var string Thinkific Domain
     */
    private $domain;

    /**
     * @var string Thinkific API Version
     */
    private $version;

    /**
     * @var array $extraRequestHeaders
     */
    private $extraRequestHeaders;

    /**
     * @var array $rateLimitDetails
     */
    protected $rateLimitDetails = [];

    /**
     * @var ThinkificUsers $users
     */
    public $users;

    /**
     * ThinkificClient constructor.
     *
     * @param string $apiToken App Token.
     * @param string $domain Domain
     * @param array $extraRequestHeaders Extra request headers to be sent in every api request
     * @param int $version API Version in use
     */
    public function __construct(string $apiToken, string $domain, array $extraRequestHeaders = [], $version = 1)
    {
        $this->users = new ThinkificUsers($this);

        $this->apiToken = $apiToken;
        $this->domain = $domain;
        $this->extraRequestHeaders = $extraRequestHeaders;
        $this->version = $version;

        $this->httpClient = $this->getDefaultHttpClient();
        $this->requestFactory = MessageFactoryDiscovery::find();
        $this->uriFactory = UriFactoryDiscovery::find();

    }

    /**
     * Sets the HTTP client.
     *
     * @param HttpClient $httpClient
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Sets the request factory.
     *
     * @param RequestFactory $requestFactory
     */
    public function setRequestFactory(RequestFactory $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }

    /**
     * Sets the URI factory.
     *
     * @param UriFactory $uriFactory
     */
    public function setUriFactory(UriFactory $uriFactory)
    {
        $this->uriFactory = $uriFactory;
    }

    /**
     * Sends POST request to Thinkific API.
     *
     * @param  string $endpoint
     * @param  array $json
     * @return stdClass
     */
    public function post($endpoint, $json)
    {
        $response = $this->sendRequest('POST', "https://api.intercom.io/$endpoint", $json);
        return $this->handleResponse($response);
    }

    /**
     * Sends PUT request to Thinkific API.
     *
     * @param  string $endpoint
     * @param  array $json
     * @return stdClass
     */
    public function put($endpoint, $json)
    {
        $response = $this->sendRequest('PUT', "https://api.thinkific.com/api/public/v$this->version/$endpoint", $json);
        return $this->handleResponse($response);
    }

    /**
     * Sends DELETE request to Thinkific API.
     *
     * @param  string $endpoint
     * @param  array $json
     * @return stdClass
     */
    public function delete($endpoint, $json)
    {
        $response = $this->sendRequest('DELETE', "https://api.thinkific.com/api/public/v$this->version/$endpoint", $json);
        return $this->handleResponse($response);
    }

    /**
     * Sends GET request to Thinkific API.
     *
     * @param string $endpoint
     * @param array  $queryParams
     * @return stdClass
     */
    public function get($endpoint, $queryParams = [])
    {
        $uri = $this->uriFactory->createUri("https://api.thinkific.com/api/public/v$this->version/$endpoint");
        if (!empty($queryParams)) {
            $uri = $uri->withQuery(http_build_query($queryParams));
        }

        $response = $this->sendRequest('GET', $uri);

        return $this->handleResponse($response);
    }

    /**
     * Returns the next page of the result.
     *
     * @param  stdClass $pages
     * @return stdClass
     */
    public function nextPage($pages)
    {
        $response = $this->sendRequest('GET', $pages->next);
        return $this->handleResponse($response);
    }

    /**
     * Gets the rate limit details.
     *
     * @return array
     */
    public function getRateLimitDetails()
    {
        return $this->rateLimitDetails;
    }

    /**
     * @return HttpClient
     */
    private function getDefaultHttpClient()
    {
        return new PluginClient(
            HttpClientDiscovery::find(),
            [new ErrorPlugin()]
        );
    }

    /**
     * @return array
     */
    private function getRequestHeaders()
    {
        return array_merge(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            $this->extraRequestHeaders
        );
    }

    /**
     * @return array
     */
    private function getRequestAuthHeaders()
    {
        return
            [
                'X-Auth-API-Key' => $this->apiToken,
                'X-Auth-Subdomain' => $this->domain
            ];
    }

    /**
     * @param string              $method
     * @param string|UriInterface $uri
     * @param array|string|null   $body
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    private function sendRequest($method, $uri, $body = null)
    {
        $headers = $this->getRequestHeaders();

        $authHeaders = $this->getRequestAuthHeaders();

        $headers = array_merge($headers, $authHeaders);

        $body = is_array($body) ? json_encode($body) : $body;

        $request = $this->requestFactory->createRequest($method, $uri, $headers, $body);

        return $this->httpClient->sendRequest($request);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return stdClass
     */
    private function handleResponse(ResponseInterface $response)
    {
        $this->setRateLimitDetails($response);

        $stream = $response->getBody()->getContents();

        return json_decode($stream);
    }

    /**
     * @param ResponseInterface $response
     */
    private function setRateLimitDetails(ResponseInterface $response)
    {
        $this->rateLimitDetails = [
            'limit' => $response->hasHeader('RateLimit-Limit')
                ? (int)$response->getHeader('RateLimit-Limit')[0]
                : null,
            'remaining' => $response->hasHeader('RateLimit-Remaining')
                ? (int)$response->getHeader('RateLimit-Remaining')[0]
                : null,
            'reset_at' => $response->hasHeader('RateLimit-Reset')
                ? (new \DateTimeImmutable())->setTimestamp((int)$response->getHeader('RateLimit-Reset')[0])
                : null,
        ];
    }


}