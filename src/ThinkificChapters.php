<?php


namespace Thinkific;

use Http\Client\Exception;
use stdClass;

class ThinkificChapters extends ThinkificResource
{

    /**
     * Gets a single Chapter by Chapter ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function getChapter($id)
    {
        $path = $this->chapterPath($id);

        return $this->client->get($path);
    }

    /**
     * Gets the contents of a given chapter by Chapter ID
     *
     * @see    https://developers.thinkific.com/api/api-documentation/
     * @param  string $id
     * @return stdClass
     * @throws Exception
     */
    public function getChapterContents($id)
    {
        $path = $this->chapterPath($id);

        return $this->client->get($path.'/contents');
    }

    /**
     * @param string $id
     * @return string
     */
    public function chapterPath(string $id)
    {
        return '/chapters/' . $id;
    }
}
