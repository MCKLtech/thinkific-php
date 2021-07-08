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
    public function list(array $options = [])
    {
        return $this->client->get('groups', $options);
    }

    /**
     * Create a Group
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function create(string $name, array $options = [])
    {
        return $this->client->post('groups', array_merge(['name' => $name], $options));
    }

    /**
     * Get a Group by ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param string $id
     * @return stdClass
     */
    public function get(string $id)
    {
        return $this->client->get("groups/$id");
    }

    /**
     * Get Group Analysts
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param string $id
     * @return stdClass
     */
    public function analysts(string $id)
    {
        return $this->client->get("groups/$id/analysts");
    }

    /**
     * Get Assign Group Analysts
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param string $group_id
     * @param array $user_ids
     * @return stdClass
     */
    public function assignAnalysts(string $group_id, array $user_ids)
    {
        return $this->client->post("groups/$group_id/analysts", ['user_ids' => $user_ids]);
    }

    /**
     * Get Assign Group Analysts
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param string $group_id
     * @param $user_id
     * @return stdClass
     */
    public function deleteAnalyst(string $group_id, $user_id)
    {
        return $this->client->delete("groups/$group_id/analysts/$user_id");
    }
}
