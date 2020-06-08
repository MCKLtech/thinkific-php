<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificProducts extends ThinkificResource
{

    /**
     * Lists Products
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function list(array $options = [])
    {
        return $this->client->get('products', $options);
    }

    /**
     * Gets a single product
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function get($id)
    {
        return $this->client->get('products/'.$id);
    }

    /**
     * Gets related products
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function related($id)
    {
        return $this->client->get('products/'.$id.'/related');
    }


}
