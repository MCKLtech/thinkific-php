<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificCategoryMemberships extends ThinkificResource
{
    /**
     * Add products to a category
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id Category ID
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function add($id, array $options)
    {
        $path = $this->categoryPath($id);

        return $this->client->post($path, $options);
    }

    /**
     * Remove products from a category
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function delete($id, array $options = [])
    {
        $path = $this->categoryPath($id);

        return $this->client->delete($path, $options);
    }

    /**
     * @param string $id
     * @return string
     */
    public function categoryPath(string $id)
    {
        return '/collection_memberships/' . $id;
    }

}
