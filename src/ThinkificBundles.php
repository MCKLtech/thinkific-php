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
     * Expires a Bundle Enrollment.
     * Wrapper for update which sets expiry date to today at midnight
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param $bundle_id Bundle ID
     * @param $user_id Thinkific User ID
     * @param bool $expiry_date Expiry Date in ISO 8601 Format
     * @return stdClass
     * @throws Exception
     */
    public function expire($bundle_id, $user_id, $expiry_date = false)
    {
        if(!$expiry_date) {

            $expiry_date = date('c', strtotime('today'));
        }

        $options = [
            'user_id' => $user_id,
            'expiry_date' => $expiry_date
        ];

        return $this->update($bundle_id, $options);
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
