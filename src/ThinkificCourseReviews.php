<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificCourseReviews extends ThinkificResource
{

    /**
     * List Course Reviews
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param array $options
     * @return stdClass
     */
    public function list(array $options = [])
    {
        return $this->client->get('course_reviews', $options);
    }

    /**
     * Lists reviews for a given course ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getCourseReviews($id, array $options = [])
    {
        return $this->list(array_merge(['course_id' => $id], $options));
    }

    /**
     * Creates a review for a given course ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function create($id, array $options = [])
    {
        $path = 'course_reviews/?course_id='.$id;

        return $this->client->post($path, $options);
    }

    /**
     * Retrieves a single review by it's review ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function get($id)
    {
        return $this->client->get('course_reviews/'.$id);
    }
}
