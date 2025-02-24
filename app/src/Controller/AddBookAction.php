<?php declare(strict_types=1);

namespace App\Controller;

use App\Controller\Request\AddBookRequest;
use App\Manager\AddBookManager;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/books', name: 'add_book', methods: ['POST'])]
#[OA\Post(
    description: 'Add book',
    requestBody: new OA\RequestBody(required: true, content: new Model(type: AddBookRequest::class)),
    tags: ['Books'],
    responses: [
        new OA\Response(
            response: '201',
            description: 'Success',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'message', type: 'string', example: 'Book has been successfully added'),
                ],
                type: 'object'
            )
        ),
        new OA\Response(
            response: '422',
            description: 'Validation Error'
        ),
    ]
)]
#[AsController]
readonly class AddBookAction
{
    public function __construct(private AddBookManager $manager)
    {
    }

    public function __invoke(#[MapRequestPayload] AddBookRequest $request)
    {
        $this->manager->create(
            title: $request->getTitle(),
            publisher: $request->getPublisher(),
            author: $request->getAuthor(),
            genre: $request->getGenre(),
            publicationDate: $request->getPublicationDate(),
            priceUsd: $request->getPriceUsd(),
            wordCount: $request->getWordCount()
        );

        return new JsonResponse(['message' => 'Book has been successfully added'], Response::HTTP_CREATED);
    }
}
