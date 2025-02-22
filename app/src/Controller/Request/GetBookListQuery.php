<?php declare(strict_types=1);

namespace App\Controller\Request;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

readonly class GetBookListQuery
{
    private const DEFAULT_OFFSET = 0;

    private const DEFAULT_LIMIT = 10;

    public function __construct(
        #[Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\PositiveOrZero(),
            new Assert\Type(type: 'digit'),
        ])]
        #[OA\Property(type: 'integer', example: 0, nullable: true, x: ['required' => false])]
        private mixed $offset = null,

        #[Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\Positive(),
            new Assert\Type(type: 'digit'),
        ])]
        #[OA\Property(type: 'integer', example: 10, nullable: true, x: ['required' => false])]
        private mixed $limit = null,
    ) {
    }

    public function getOffset(): int
    {
        return (int) ($this->offset ?? self::DEFAULT_OFFSET);
    }

    public function getLimit(): int
    {
        return (int) ($this->limit ?? self::DEFAULT_LIMIT);
    }
}
