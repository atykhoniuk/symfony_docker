<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AddBookFunctionalTest extends WebTestCase
{
    public function testCreateBookSuccess(): void
    {
        $client = static::createClient();

        $data = [
            'title' => 'Test Title Add Book Controller',
            'author' => 'Test Author',
            'publisher' => 'Test Publisher',
            'genre' => 'Test Genre',
            'publicationDate' => '2023-01-01',
            'priceUsd' => 19.99,
            'wordCount' => 1000
        ];

        $client->request(
            method: 'POST',
            uri: '/api/books',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($data)
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Book has been successfully added']),
            $response->getContent()
        );

        $container = static::getContainer();
        $entityManager = $container->get(EntityManagerInterface::class);
        $book = $entityManager->getRepository(Book::class)->findOneBy(['title' => $data['title']]);

        $this->assertNotNull($book);
        $this->assertEquals($data['author'], $book->getAuthor());
        $this->assertEquals($data['publisher'], $book->getPublisher());
        $this->assertEquals($data['genre'], $book->getGenre());
        $this->assertEquals(new \DateTime('2023-01-01'), $book->getPublicationDate());
        $this->assertEquals($data['priceUsd'], $book->getPriceUsd());
        $this->assertEquals($data['wordCount'], $book->getWordCount());
    }

    public function testCreateBookError(): void
    {
        $client = static::createClient();

        $data = [
            'title' => '',
            'author' => '',
            'publisher' => 'Test Publisher',
            'genre' => 'Test Genre',
            'publicationDate' => '2023-01-01',
            'priceUsd' => 19.99,
            'wordCount' => 1000
        ];

        $client->request(
            method: 'POST',
            uri: '/api/books',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($data)
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }
}
