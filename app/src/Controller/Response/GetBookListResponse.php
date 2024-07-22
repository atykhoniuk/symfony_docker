<?php declare(strict_types=1);

namespace App\Controller\Response;

use App\Entity\Book;
use ArrayIterator;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;


class GetBookListResponse
{
    public function __construct(
        #[OA\Property(type: 'array', items: new OA\Items(ref: new Model(type: Book::class)), nullable: false)]
        public array $items,

        public int $offset,

        public int $limit,

        public int $total,
    ) {
    }
}
