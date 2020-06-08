<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificGroups extends ThinkificResource
{

    /**
     * Lists Groups
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function get(array $options = [])
    {
        return $this->client->get('groups', $options);
    }
}
