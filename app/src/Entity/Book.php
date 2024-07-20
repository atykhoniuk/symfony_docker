<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\BookRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Table]
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 64)]
    private string $title;

    #[ORM\Column(type: 'string', length: 32)]
    private string $publisher;

    #[ORM\Column(type: 'string', length: 32)]
    private string $author;

    #[ORM\Column(type: 'string', length: 32)]
    private string $genre;

    #[ORM\Column(name: 'publication_date', type: 'date')]
    private DateTimeInterface $publicationDate;

    #[ORM\Column(name: 'word_count', type: 'integer')]
    private $wordCount;

    #[ORM\Column(name: 'price_usd', type: 'decimal', scale: 2)]
    private float $priceUsd;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPublisher(): string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPublicationDate(): DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getWordCount(): int
    {
        return $this->wordCount;
    }

    public function setWordCount(int $wordCount): self
    {
        $this->wordCount = $wordCount;

        return $this;
    }

    public function getPriceUsd(): float
    {
        return $this->priceUsd;
    }

    public function setPriceUsd(float $priceUsd): self
    {
        $this->priceUsd = $priceUsd;

        return $this;
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'publisher' => $this->publisher,
            'author' => $this->author,
            'genre' => $this->genre,
            'publication_date' => $this->publicationDate->format('Y-m-d'),
            'price_usd' => $this->priceUsd,
            'word_count' => $this->wordCount,
        ];
    }
}
