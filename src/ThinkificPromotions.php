<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificPromotions extends ThinkificResource
{

    /**
     * Lists Promotions
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function list(array $options = [])
    {
        return $this->client->get('promotions', $options);
    }

    /**
     * Creates a Promotion
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function create(array $options)
    {
        return $this->client->post('promotions', $options);
    }

    /**
     * Retrieves a single promotion by ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function get($id)
    {
        $path = $this->promotionPath($id);

        return $this->client->get($path);
    }

    /**
     * Updates a promotion by ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function update($id, array $options)
    {
        $path = $this->promotionPath($id);

        return $this->client->put($path, $options);
    }

    /**
     * Deletes a promotion by ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function delete($id)
    {
        $path = $this->promotionPath($id);

        return $this->client->delete($path, []);
    }

    /**
     * Retrieve Promotion by Coupon Code & Product
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $product_id
     * @param  string $coupon_code
     * @return stdClass
     * @throws Exception
     */
    public function getByCoupon($product_id, $coupon_code)
    {
        $options = [
            'product_id' => $product_id,
            'coupon_code' => $coupon_code,
        ];

        return $this->client->get('promotions', $options);
    }

    /**
     * @param string $id
     * @return string
     */
    public function promotionPath(string $id)
    {
        return 'promotions/' . $id;
    }

}
