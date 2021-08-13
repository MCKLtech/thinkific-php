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
    public $httpClient;

    /**
     * @var RequestFactory $requestFactory
     */
    public $requestFactory;

    /**
     * @var UriFactory $uriFactory
     */
    public $uriFactory;

    /**
     * @var string API or OAuth Token
     */
    public $apiToken;

    /**
     * @var string Thinkific Domain
     */
    public $domain;

    /**
     * @var string Thinkific API Version
     */
    private $version;

    /**
     * @var bool Use OAuth
     */
    private $is_oauth;

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
     * @var ThinkificBundles $bundles
     */
    public $bundles;

    /**
     * @var ThinkificCategories $categories
     */
    public $categories;

    /**
     * @var ThinkificCategoryMemberships $memberships
     */
    public $memberships;

    /**
     * @var ThinkificChapters $chapters
     */
    public $chapters;

    /**
     * @var ThinkificContents $contents
     */
    public $contents;

    /**
     * @var ThinkificCoupons $coupons
     */
    public $coupons;

    /**
     * @var ThinkificCourses $courses
     */
    public $courses;

    /**
     * @var ThinkificCourseReviews $reviews
     */
    public $reviews;

    /**
     * @var ThinkificProfileFields $fields
     */
    public $fields;

    /**
     * @var ThinkificEnrollments $enrollments
     */
    public $enrollments;

    /**
     * @var ThinkificGroups $groups
     */
    public $groups;

    /**
     * @var ThinkificGroupUsers $groupUsers
     */
    public $groupUsers;

    /**
     * @var ThinkificInstructors $instructors
     */
    public $instructors;

    /**
     * @var ThinkificOrders $orders
     */
    public $orders;

    /**
     * @var ThinkificProductPublishRequests $publishRequests
     */
    public $publishRequests;

    /**
     * @var ThinkificProducts $products
     */
    public $products;

    /**
     * @var ThinkificPromotions $promotions
     */
    public $promotions;

    /**
     * @var ThinkificOAuth $oauth
     */
    public $oauth;

    /**
     * @var ThinkificWebhooks $webhooks
     */
    public $webhooks;

    /**
     * @var ThinkificSiteScripts $siteScripts
     */
    public $siteScripts;

    public $thinkificApiEndPoint = 'https://api.thinkific.com/api/public';

    /**
     * ThinkificClient constructor.
     *
     * @param string $apiToken App Token.
     * @param string $domain Domain
     * @param array $extraRequestHeaders Extra request headers to be sent in every api request
     * @param int $version API Version in use
     * @param bool $oauth Set true if using OAuth token instead of API key
     */
    public function __construct(string $apiToken, string $domain, array $extraRequestHeaders = [], $version = 1, $oauth = false)
    {
        $this->users = new ThinkificUsers($this);
        $this->bundles = new ThinkificBundles($this);
        $this->categories = new ThinkificCategories($this);
        $this->memberships = new ThinkificCategoryMemberships($this);
        $this->chapters = new ThinkificChapters($this);
        $this->contents = new ThinkificContents($this);
        $this->coupons = new ThinkificCoupons($this);
        $this->courses = new ThinkificCourses($this);
        $this->reviews = new ThinkificCourseReviews($this);
        $this->fields = new ThinkificProfileFields($this);
        $this->enrollments = new ThinkificEnrollments($this);
        $this->groups = new ThinkificGroups($this);
        $this->groupUsers = new ThinkificGroupUsers($this);
        $this->instructors = new ThinkificInstructors($this);
        $this->orders = new ThinkificOrders($this);
        $this->publishRequests = new ThinkificProductPublishRequests($this);
        $this->products = new ThinkificProducts($this);
        $this->promotions = new ThinkificPromotions($this);

        $this->oauth = new ThinkificOAuth($this);
        $this->webhooks = new ThinkificWebhooks($this);
        $this->siteScripts = new ThinkificSiteScripts($this);

        $this->apiToken = $apiToken;
        $this->domain = $domain;
        $this->extraRequestHeaders = $extraRequestHeaders;
        $this->version = $version;
        $this->is_oauth = $oauth;

        $this->httpClient = $this->getDefaultHttpClient();
        $this->requestFactory = MessageFactoryDiscovery::find();
        $this->uriFactory = UriFactoryDiscovery::find();
    }

    /**
     * Allows us to change the end point
     * @param $end_point
     */
    public function setEndpoint($end_point)
    {
        $this->thinkificApiEndPoint = $end_point;
    }

    /**
     * Sets the HTTP client.
     * e.g. https://api.thinkific.com/api/v2 for Webhooks
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
     * Sets true if using OAuth
     *
     * @param bool $is_oauth
     */
    public function setOAuth($is_oauth)
    {
        $this->is_oauth = $is_oauth;
    }

    /**
     * Determines if a response has more pages
     *
     * @param stdClass $response
     * @return bool
     */
    public function hasMore(stdClass $response)
    {

        if (isset($response->meta->pagination)) {
            return $response->meta->pagination->current_page < $response->meta->pagination->next_page;
        }

        return false;
    }

    /**
     * Returns the next page number of a response
     *
     * @param string $path
     * @param stdClass $response
     * @return int
     * @throws ClientExceptionInterface
     */
    public function nextPage(stdClass $response)
    {
        return isset($response->meta->pagination->next_page) ? $response->meta->pagination->next_page : 1;
    }

    /**
     * Sends POST request to Thinkific API.
     *
     * @param string $endpoint
     * @param array $json
     * @return stdClass
     */
    public function post($endpoint, $json)
    {
        $response = $this->sendRequest('POST', $this->thinkificApiEndPoint . "/v$this->version/$endpoint", $json);
        return $this->handleResponse($response);
    }

    /**
     * Sends PUT request to Thinkific API.
     *
     * @param string $endpoint
     * @param array $json
     * @return stdClass
     */
    public function put($endpoint, $json)
    {
        $response = $this->sendRequest('PUT', $this->thinkificApiEndPoint . "/v$this->version/$endpoint", $json);
        return $this->handleResponse($response);
    }

    /**
     * Sends DELETE request to Thinkific API.
     *
     * @param string $endpoint
     * @param array $json
     * @return stdClass
     */
    public function delete($endpoint, $json = [])
    {
        $response = $this->sendRequest('DELETE', $this->thinkificApiEndPoint . "/v$this->version/$endpoint", $json);
        return $this->handleResponse($response);
    }

    /**
     * Sends GET request to Thinkific API.
     *
     * @param string $endpoint
     * @param array $queryParams
     * @return stdClass
     */
    public function get($endpoint, $queryParams = [])
    {

        $uri = $this->uriFactory->createUri($this->thinkificApiEndPoint . "/v$this->version/$endpoint");

        if (!empty($queryParams)) {
            $uri = $uri->withQuery(http_build_query($queryParams));
        }

        $response = $this->sendRequest('GET', $uri);

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

        if ($this->is_oauth) {
            $headers = [
                'Authorization' => 'Bearer ' . $this->apiToken
            ];
        } else {
            $headers = [
                'X-Auth-API-Key' => $this->apiToken,
                'X-Auth-Subdomain' => $this->domain
            ];
        }

        return $headers;
    }

    /**
     * @param string $method
     * @param string|UriInterface $uri
     * @param array|string|null $body
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
    public function handleResponse(ResponseInterface $response)
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
            'reset_at' => $response->hasHeader('RateLimit-Reset')
                ? (int)$response->getHeader('RateLimit-Reset')
                : null,
        ];
    }
}
