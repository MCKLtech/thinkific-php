<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificInstructors extends ThinkificResource
{

    /**
     * Lists Instructors
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function list(array $options = [])
    {
        return $this->client->get('instructors', $options);
    }

    /**
     * Creates an Instructor
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function create(array $options)
    {
        return $this->client->post('instructors', $options);
    }

    /**
     * Gets a single instructor
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function get($id)
    {
        return $this->client->get('instructors/'.$id);
    }

    /**
     * Update an instructor
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function update($id, array $options)
    {
        return $this->client->put('instructors/'.$id, $options);
    }

    /**
     * Delete an instructor
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function delete($id)
    {
        return $this->client->delete('instructors/'.$id);
    }

}
