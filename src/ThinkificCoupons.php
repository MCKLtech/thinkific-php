<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificCoupons extends ThinkificResource
{

    /**
     * Get Coupons
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getCoupons(array $options = [])
    {
        return $this->client->get('coupons', $options);
    }

    /**
     * Create a Coupon
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function create($id, array $options)
    {
        $path = $this->couponPath($id);

        return $this->client->post($path, $options);
    }

    /**
     * Bulk Create Coupons
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function createBulk($id, array $options)
    {
        $path = $this->couponPath($id);

        return $this->client->post($path, $options);
    }

    /**
     * Get Single Coupon
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function getCoupon($id)
    {
        $path = $this->couponPath($id);

        return $this->client->get($path);
    }

    /**
     * Update A Single Coupon
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @param array $options
     * @return stdClass
     * @throws Exception
     */
    public function update($id, array $options)
    {
        $path = $this->couponPath($id);

        return $this->client->put($path, $options);
    }

    /**
     * Delete A Coupon
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @param array $options
     * @return stdClass
     * @throws Exception
     */
    public function delete($id, array $options = [])
    {
        $path = $this->couponPath($id);

        return $this->client->delete($path, $options);
    }

    /**
     * @param string $id
     * @return string
     */
    public function couponPath(string $id)
    {
        return 'coupons/' . $id;
    }
}
