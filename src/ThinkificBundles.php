<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificBundles extends ThinkificResource
{

    /**
     * Get Bundles
     * WARNING: This end point does not exist, it is only included for completion and in hopes it will exist int the future
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getBundles(array $options = [])
    {
        return $this->client->get('bundles', $options);
    }

    /**
     * Gets a single Bundle by Bundle ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id Bundle ID
     * @return stdClass
     * @throws Exception
     */
    public function getBundle($id)
    {
        $path = $this->bundlePath($id);

        return $this->client->get($path);
    }

    /**
     * Gets courses in Bundle
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id Bundle ID
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getBundleCourses($id, array $options = [])
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
    public function getBundleEnrollments($id, array $options = [])
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
    public function createEnrollment($id, array $options)
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
    public function updateEnrollment($id, array $options)
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
