<?php declare(strict_types=1);

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Book;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetBookListFunctionalTest extends WebTestCase
{
    use ReloadDatabaseTrait;
    public function testGetBookListSuccess()
    {
        $client = static::createClient();

        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        $book = new Book();
        $book->setTitle('Test Book');
        $book->setPublisher('Test Publisher');
        $book->setAuthor('Test Author');
        $book->setGenre('Test Genre');
        $book->setPublicationDate(new \DateTime('2023-01-01'));
        $book->setWordCount(1000);
        $book->setPriceUsd(19.99);

        $entityManager->persist($book);
        $entityManager->flush();

        $bookId = $book->getId();

        $client->request(
            method: 'GET',
            uri: '/api/books',
            parameters: [
                'offset' => 0,
                'limit' => 1,
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $expectedData = [
            'items' => [
                ['id' => 1,
                'title' => 'Test Book',
                'author' => 'Test Author',
                'publisher' => 'Test Publisher',
                'genre' => 'Test Genre',
                'publication_date' => '2023-01-01',
                'price_usd' => 19.99,
                'word_count' => 1000]
            ],
            'offset' => 0,
            'limit' => 1,
            'total' => 1
        ];

        $this->assertJsonStringEqualsJsonString(
            json_encode($expectedData),
            $response->getContent()
        );
    }

}
