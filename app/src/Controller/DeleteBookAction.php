<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/books/{book}', name: 'delete_book_by_id', methods: ['DELETE'])]
#[OA\Delete(
    description: 'Delete book',
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
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'message', type: 'string', example: 'Book has been deleted'),
                ],
                type: 'object'
            )
        ),
        new OA\Response(
            response: '404',
            description: 'Not Found',
        ),
    ]
)]
#[AsController]
readonly class DeleteBookAction
{
    public function __construct(private BookRepository $bookRepository)
    {
    }

    public function __invoke(Book $book): JsonResponse
    {
        $this->bookRepository->delete($book);

        return new JsonResponse(
            ['message' => 'Book has been deleted'],
            Response::HTTP_OK
        );
    }
}
