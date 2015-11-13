<?php
namespace AppBundle\Utils;


class BookFilter
{
        public function filter ($booksToFilter, $keywords) {
            $filteredBooks = [];
            foreach ($booksToFilter as $book){
                foreach ($keywords as $keyword){
                    if (strripos($book->itemTitle, $keyword)!==false){
                        $filteredBooks[] = new Ebook($book->itemId, $book->itemTitle);
                    }
                }
            }
            return $filteredBooks;
        }
}