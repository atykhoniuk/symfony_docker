<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UpdateBookFunctionalTest extends WebTestCase
{
    public function testUpdateBookSuccess(): void
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

        $data = [
            'author' => 'Test Author Updated',
        ];

        $client->request(
            method: 'PATCH',
            uri: '/api/books/' . $bookId,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($data)
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Book has been successfully updated']),
            $response->getContent()
        );

        $container = static::getContainer();
        $entityManager = $container->get(EntityManagerInterface::class);
        $book = $entityManager->getRepository(Book::class)->findOneById($bookId);

        $this->assertNotNull($book);
        $this->assertEquals($data['author'], $book->getAuthor());
    }

    public function testUpdateBookError(): void
    {
        $client = static::createClient();

        $data = [
            'title' => 'Test',
        ];

        $client->request(
            method: 'PATCH',
            uri: '/api/books/' . 99999,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($data)
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
