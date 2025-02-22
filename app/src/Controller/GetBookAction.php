<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Book;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/books/{book}', name: 'get_book_by_id', methods: ['GET'])]
#[OA\Get(
    description: 'Get book by id',
    tags: ['Books'],
    parameters: [
        new OA\Parameter(
            name: 'book',
            description: 'Book id',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'integer', example: 1)
        ),
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Success',
            content: [
                new OA\JsonContent(ref: new Model(type: Book::class)),
            ]
        ),
        new OA\Response(
            response: '404',
            description: 'Not Found',
        ),
    ]
)]
#[AsController]
readonly class GetBookAction
{
    public function __invoke(Book $book): JsonResponse
    {
        return new JsonResponse($book, Response::HTTP_OK);
    }
}
