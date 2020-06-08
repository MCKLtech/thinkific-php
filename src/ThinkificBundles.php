<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificBundles extends ThinkificResource
{
    /**
     * Gets a single Bundle by Bundle ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id Bundle ID
     * @return stdClass
     * @throws Exception
     */
    public function get($id)
    {
        $path = $this->bundlePath($id);

        return $this->client->get($path);
    }

    /**
     * Gets courses in a given Bundle
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id Bundle ID
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getCourses($id, array $options = [])
    {
        $path = $this->bundlePath($id);

        return $this->client->get($path.'/courses', $options);
    }

    /**
     * Gets enrollments in Bundle
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id Bundle ID
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getEnrollments($id, array $options = [])
    {
        $path = $this->bundlePath($id);

        return $this->client->get($path.'/enrollments', $options);
    }

    /**
     * Creates enrollment in Bundle
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id Bundle ID
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function create($id, array $options)
    {
        $path = $this->bundlePath($id);

        return $this->client->post($path.'/enrollments', $options);
    }

    /**
     * Updates enrollment in Bundle
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id Bundle ID
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function update($id, array $options)
    {
        $path = $this->bundlePath($id);

        return $this->client->put($path.'/enrollments', $options);
    }

    /**
     * @param string $id
     * @return string
     */
    public function bundlePath(string $id)
    {
        return 'bundles/' . $id;
    }
}
