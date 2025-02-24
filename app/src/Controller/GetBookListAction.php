<?php declare(strict_types=1);

namespace App\Controller;

use App\Controller\Request\GetBookListQuery;
use App\Controller\Response\GetBookListResponse;
use App\Repository\BookRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/books', name: 'get_books_list', methods: ['GET'])]
#[OA\Get(
    description: 'Get book list',
    tags: ['Books'],
    parameters: [
        new OA\Parameter(
            name: 'limit',
            description: 'Limit per page',
            in: 'query',
            required: true,
            schema: new OA\Schema(type: 'integer', example: 10)
        ),
        new OA\Parameter(
            name: 'offset',
            description: 'Offset',
            in: 'query',
            required: true,
            schema: new OA\Schema(type: 'integer', example: 0)
        ),
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Success',
            content: [
                new OA\JsonContent(
                    allOf: [
                        new OA\Schema(ref: new Model(type: GetBookListResponse::class)),
                    ],
                ),
            ]
        ),
    ]
)]
#[AsController]
readonly class GetBookListAction
{
    public function __construct(public BookRepository $bookRepository)
    {
    }

    public function __invoke(#[MapQueryString]GetBookListQuery $query): JsonResponse
    {
        $paginatedBookList = $this->bookRepository->getPaginatedBookList($query->getOffset(), $query->getLimit());

        return new JsonResponse(
            new GetBookListResponse(
                iterator_to_array($paginatedBookList->getIterator(), false),
                $query->getOffset(),
                $query->getLimit(),
                $paginatedBookList->count()
            ),
            Response::HTTP_OK
        );
    }
}
