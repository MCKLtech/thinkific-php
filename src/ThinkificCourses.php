<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificCourses extends ThinkificResource
{

    /**
     * Lists Courses
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function list(array $options = [])
    {
        return $this->client->get('courses', $options);
    }

    /**
     * Get single course by ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function get($id)
    {
        return $this->client->get('courses/'.$id);
    }

    /**
     * Get chapters of a single course by ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getChapters($id, array $options = [])
    {
        return $this->client->get('courses/'.$id, $options);
    }
}
