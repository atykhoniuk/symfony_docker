<?php declare(strict_types=1);

namespace App\Manager;

use App\Entity\Book;
use App\Repository\BookRepository;
use DateTimeInterface;

readonly class UpdateBookManager
{
    public function __construct(
        public BookRepository $repository
    ) {
    }

    public function update(
        Book $book,
        ?string $title,
        ?string $publisher,
        ?string $author,
        ?string $genre,
        ?DateTimeInterface $publicationDate,
        ?float $priceUsd,
        ?int $wordCount
    ): void
    {
        $updates = [
            'title' => $title,
            'publisher' => $publisher,
            'author' => $author,
            'genre' => $genre,
            'publicationDate' => $publicationDate,
            'priceUsd' => $priceUsd,
            'wordCount' => $wordCount
        ];

        $methods = [
            'title' => 'setTitle',
            'publisher' => 'setPublisher',
            'author' => 'setAuthor',
            'genre' => 'setGenre',
            'publicationDate' => 'setPublicationDate',
            'priceUsd' => 'setPriceUsd',
            'wordCount' => 'setWordCount'
        ];

        foreach ($updates as $field => $value) {
            if ($value !== null) {
                $method = $methods[$field];
                $book->$method($value);
            }
        }

        $this->repository->save($book);
    }
}
