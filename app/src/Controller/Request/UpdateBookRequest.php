<?php declare(strict_types=1);

namespace App\Controller\Request;

use DateTimeInterface;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

readonly class UpdateBookRequest
{
    public function __construct(
        #[Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\Type('string'),
        ])]
        #[OA\Property(type: 'string', example: 'Book Title', nullable: false)]
        private mixed $title,

        #[Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\Type('string'),
        ])]
        #[OA\Property(type: 'string', example: 'Book Publisher', nullable: false)]
        private mixed $publisher,

        #[Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\Type('string'),
        ])]
        #[OA\Property(type: 'string', example: 'Book Author', nullable: false)]
        private mixed $author,

        #[Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\Type('string'),
        ])]
        #[OA\Property(type: 'string', example: 'Book Genre', nullable: false)]
        private mixed $genre,

        #[Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\Type(DateTimeInterface::class),
        ])]
        #[OA\Property(type: 'string', format: 'date-time', example: '2023-05-29T07:04:58+00:00', nullable: false)]
        private mixed $publicationDate,

        #[Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\Type('float'),
        ])]
        #[OA\Property(type: 'float', example: 20.99, nullable: false)]
        private mixed $priceUsd,

        #[Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\Type('int'),
        ])]
        #[OA\Property(type: 'integer', example: 1000, nullable: false)]
        private mixed $wordCount
    ) {
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function getPublicationDate(): ?DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function getPriceUsd(): ?float
    {
        return $this->priceUsd;
    }

    public function getWordCount(): ?int
    {
        return $this->wordCount;
    }
}
