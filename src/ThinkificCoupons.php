<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificCoupons extends ThinkificResource
{
    /**
     * Get Coupons
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param int $id Promo ID
     * @param array $options
     * @return stdClass
     */
    public function list(int $id, array $options = [])
    {
        return $this->client->get("coupons?promotion_id=$id", $options);
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
        return $this->client->post("coupons?promotion_id=$id", $options);
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
        return $this->client->post("coupons?promotion_id=$id", $options);
    }

    /**
     * Get Single Coupon
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function get($id)
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
