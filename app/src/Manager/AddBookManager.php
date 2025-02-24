<?php declare(strict_types=1);

namespace App\Manager;

use App\Entity\Book;
use App\Repository\BookRepository;
use DateTimeInterface;

readonly class AddBookManager
{
    public function __construct(
        public BookRepository $repository
    ) {
    }

    public function create(
        string $title,
        string $publisher,
        string $author,
        string $genre,
        DateTimeInterface $publicationDate,
        float $priceUsd,
        int $wordCount
    ): void
    {
        $book = (new Book())
            ->setTitle($title)
            ->setPublisher($publisher)
            ->setAuthor($author)
            ->setGenre($genre)
            ->setPublicationDate($publicationDate)
            ->setPriceUsd($priceUsd)
            ->setWordCount($wordCount);

        $this->repository->save($book);
    }
}
