<?php declare(strict_types=1);

namespace App\Controller;

use App\Controller\Request\UpdateBookRequest;
use App\Entity\Book;
use App\Manager\UpdateBookManager;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/books/{book}', name: 'update_book', methods: ['PATCH'])]
#[OA\Patch(
    description: 'Update book',
    requestBody: new OA\RequestBody(required: true, content: new Model(type: UpdateBookRequest::class)),
    tags: ['Books'],
    responses: [
        new OA\Response(
            response: '200',
            description: 'Success',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'message', type: 'string', example: 'Book has been successfully updated'),
                ],
                type: 'object'
            )
        ),
        new OA\Response(
            response: '404',
            description: 'Not Found',
        ),
        new OA\Response(
            response: '422',
            description: 'Validation Error'
        ),
    ]
)]
#[AsController]
readonly class UpdateBookAction
{
    public function __construct(private UpdateBookManager $manager)
    {
    }

    public function __invoke(Book $book, #[MapRequestPayload] UpdateBookRequest $request)
    {
        $this->manager->update(
            book: $book,
            title: $request->getTitle(),
            publisher: $request->getPublisher(),
            author: $request->getAuthor(),
            genre: $request->getGenre(),
            publicationDate: $request->getPublicationDate(),
            priceUsd: $request->getPriceUsd(),
            wordCount: $request->getWordCount()
        );

        return new JsonResponse(['message' => 'Book has been successfully updated'], Response::HTTP_OK);
    }
}
