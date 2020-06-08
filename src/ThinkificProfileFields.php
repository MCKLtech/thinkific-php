<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificProfileFields extends ThinkificResource
{
    /**
     * Lists Custom Profile Fields.
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function list(array $options = [])
    {
        return $this->client->get('custom_profile_field_definitions', $options);
    }
}
