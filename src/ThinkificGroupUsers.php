<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificGroupUsers extends ThinkificResource
{

    /**
     * Add a User to Group(s)
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id User ID
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function add($id, array $options)
    {
        $options = array_merge(['user_id' => $id], $options);

        return $this->client->post('group_users', $options);
    }
}
