<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DeleteBookActionFunctionalTest extends WebTestCase
{
    public function testDeleteBookSuccess(): void
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

        $client->request('DELETE', '/api/books/' . $bookId);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Book has been deleted']),
            $client->getResponse()->getContent()
        );

        $deletedBook = $entityManager->getRepository(Book::class)->find($bookId);
        $this->assertNull($deletedBook);
    }

    public function testDeleteError(): void
    {
        $client = static::createClient();

        $client->request('DELETE', '/api/books/' . 999999);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}
