<?php


namespace Thinkific;


abstract class ThinkificResource
{
    /**
     * @var ThinkificClient
     */
    protected $client;

    /**
     * IntercomResource constructor.
     *
     * @param ThinkificClient $client
     */
    public function __construct(ThinkificClient $client)
    {
        $this->client = $client;
    }
}