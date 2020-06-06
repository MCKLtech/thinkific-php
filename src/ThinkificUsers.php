<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificUsers extends ThinkificResource
{

    /**
     * Lists Users.
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getUsers(array $options)
    {
        return $this->client->get('users', $options);
    }

    /**
     * Creates a User.
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
    public function getUser($id)
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
     * @param string $id
     * @return string
     */
    public function userPath(string $id)
    {
        return 'users/' . $id;
    }
}