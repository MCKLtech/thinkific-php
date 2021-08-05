<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificSiteScripts extends ThinkificResource
{

    /**
     * Lists Site Scripts
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function list(array $options = [])
    {
        return $this->client->get('site_scripts', $options);
    }

    /**
     * Create a Site Script
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function create(array $options)
    {
        return $this->client->post('site_scripts', $options);
    }

    /**
     * Get a Site Script by ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param string $id
     * @return stdClass
     */
    public function get(string $id)
    {
        return $this->client->get("site_scripts/$id");
    }

    /**
     * Update a Site Script
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param string $id
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function update(string $id, array $options)
    {
        return $this->client->put("site_scripts/$id", $options);
    }

    /**
     * Delete a Site Script
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param string $id
     * @return stdClass
     */
    public function delete(string $id)
    {
        return $this->client->delete("site_scripts/$id");
    }
}
