<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificOrders extends ThinkificResource
{

    /**
     * Lists Orders
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function list(array $options = [])
    {
        return $this->client->get('orders', $options);
    }

    /**
     * Retrieves a single order
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function get($id)
    {
        return $this->client->get('orders/'.$id);
    }
}
