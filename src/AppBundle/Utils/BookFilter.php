<?php
namespace AppBundle\Utils;


class BookFilter
{
        public function filter ($booksToFilter, $keywords) {
            $filteredBooks = [];
            foreach ($booksToFilter as $book){
                if (is_array($keywords)) {
                    foreach ($keywords as $keyword){
                        if (strripos($book->itemTitle, $keyword)!==false){
                            $filteredBooks[] = new Ebook(
                                $book->itemId, $book->itemTitle,
                                $book->priceInfo->item[0]->priceValue,
                                $book->timeToEnd
                            );
                        }
                    }
                }
            }
            return $filteredBooks;
        }
}