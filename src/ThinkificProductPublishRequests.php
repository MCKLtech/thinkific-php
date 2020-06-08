<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificProductPublishRequests extends ThinkificResource
{

    /**
     * Lists Product Publish Requests
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function list(array $options = [])
    {
        return $this->client->get('product_publish_requests', $options);
    }

    /**
     * Gets a single Product Publish Request
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function get($id)
    {
        return $this->client->get('product_publish_requests/'.$id);
    }

    /**
     * Approve a Product Publish Request by ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function approve($id)
    {
        return $this->client->post('product_publish_requests/'.$id.'/approve');
    }

    /**
     * Deny a Product Publish Request by ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function deny($id)
    {
        return $this->client->post('product_publish_requests/'.$id.'/deny');
    }
}
