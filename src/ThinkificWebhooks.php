<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificWebhooks extends ThinkificResource
{
    /**
     * * IMPORTANT: Webhook endpoints must use V2 of the Thinkific API. Set version to 2 in the Client constructor
     */

    /**
     * Returns a list of webhooks currently set up on the account
     *
     *
     * @param array $options
     * @return stdClass
     */
    public function list(array $options = [])
    {
        return $this->client->get('webhooks', $options);
    }

    /**
     * Creates a webhook
     *
     * @param string $topic
     * @param string $target_url
     * @param array $options
     * @return stdClass
     */
    public function create(string $topic, string $target_url, array $options = [])
    {
        return $this->client->post('webhooks', array_merge(['topic' => $topic, 'target_url' => $target_url], $options));
    }

    /**
     * Get a webhook by ID
     *
     * @param string $id
     * @return stdClass
     */
    public function get(string $id)
    {
        return $this->client->get("webhooks/$id");
    }

    /**
     * Update a webhook by ID
     *
     * @param string $id
     * @param array $options
     * @return stdClass
     */
    public function update(string $id, array $options)
    {
        return $this->client->put("webhooks/$id", $options);
    }

    /**
     * Delete a webhook by ID
     *
     * @param string $id
     * @return stdClass
     */
    public function delete(string $id)
    {
        return $this->client->delete("webhooks/$id");
    }

    /**
     * Validates a webhook
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param string $body JSON Body from Webhook
     * @param  string|array $header
     * @return bool
     * @throws Exception
     */
    public function validate(string $body, $header)
    {
        /* We can accept an array or a string */
        if (is_array($header)) {
            $header = $header['HTTP_X_THINKIFIC_HMAC_SHA256'] ?? false;
        }

        /* We need the header for comparison */
        if (!$header) {
            return false;
        }

        $calculated = hash_hmac('sha256', $body, $this->client->apiToken, false);

        if ($calculated === $header) {
            return true;
        }

        return false;
    }
}
