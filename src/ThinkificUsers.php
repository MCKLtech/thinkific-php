<?php

namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificUsers extends ThinkificResource
{

    /**
     * Lists Users
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function list(array $options = [])
    {
        return $this->client->get('users', $options);
    }

    /**
     * Creates a User
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function create(array $options)
    {
        return $this->client->post('users', $options);
    }

    /**
     * Gets a single User based on the Thinkific ID.
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function get($id)
    {
        $path = $this->userPath($id);

        return $this->client->get($path);
    }

    /**
     * Updates a User.
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param string $id
     * @param array $options
     * @return stdClass
     */
    public function update($id, array $options)
    {
        $path = $this->userPath($id);

        return $this->client->put($path, $options);
    }

    /**
     * Deletes a User.
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param string $id
     * @return stdClass
     */
    public function delete($id)
    {
        $path = $this->userPath($id);

        return $this->client->delete($path);
    }

    /**
     * Finds Users by given params
     * See Thinkific Docs for more information & filter options
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $value The value to search by e.g. An email address
     * @param  string $query The query param e.g. 'email', 'role' etc
     * @param  bool $single Return a single result (Defaults to first result on the first page)
     * @return stdClass
     * @throws Exception
     */
    public function findBy($value, $query = 'email', $single = true)
    {
        $query = "query[$query]";

        $options = [
            $query => $value
        ];

        /* Limit to first and single result */

        if($single) {

            $options = array_merge(
                $options,
                ['page' => 1, 'limit' => 1]
            );
        }

        $result =  $this->client->get('users', $options);

        if($single && isset($result->items)) {

            return reset($result->items);
        }

        return $result;
    }

    /**
     * @param string $id
     * @return string
     */
    public function userPath(string $id)
    {
        return 'users/' . $id;
    }
}
