<?php
/**
 * Created by PhpStorm.
 * User: jakubmatyka
 * Date: 12.11.15
 * Time: 16:12
 */

namespace AppBundle\Utils;


class Ebook
{
    public $itemId;
    public $itemTitle;

    /**
     * Ebook constructor.
     * @param $itemId
     * @param $itemTitle
     */
    public function __construct($itemId, $itemTitle)
    {
        $this->itemId = $itemId;
        $this->itemTitle = $itemTitle;
    }
}