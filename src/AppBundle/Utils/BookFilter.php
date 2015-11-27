<?php
namespace AppBundle\Utils;


class BookFilter
{
    public function filter($booksToFilter, $keywords)
    {
        $filteredBooks = [];
        if ($keywords) {

            foreach ($booksToFilter as $book) {
                if (is_array($keywords)) {
                    foreach ($keywords as $keyword) {
                        if (strripos($book->itemTitle, $keyword) !== false) {
                            $filteredBooks[] = new Ebook(
                                $book->itemId, $book->itemTitle,
                                $book->priceInfo->item[0]->priceValue,
                                $book->timeToEnd,
                                $book->photosInfo->item[1]->photoUrl
                            );
                        }
                    }
                }
            }
        } else {
            foreach ($booksToFilter as $book) {
                $filteredBooks[] = new Ebook(
                    $book->itemId, $book->itemTitle,
                    $book->priceInfo->item[0]->priceValue,
                    $book->timeToEnd,
                    $book->photosInfo->item[1]->photoUrl
                );
            }
        }

        return $filteredBooks;
    }
}
