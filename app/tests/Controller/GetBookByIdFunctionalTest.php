<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetBookByIdFunctionalTest extends WebTestCase
{
    public function testGetBookSuccess()
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

        $client->request('GET', '/api/books/' . $bookId);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $expectedData = [
            'id' => $bookId,
            'title' => 'Test Book',
            'author' => 'Test Author',
            'publisher' => 'Test Publisher',
            'genre' => 'Test Genre',
            'publication_date' => '2023-01-01',
            'price_usd' => 19.99,
            'word_count' => 1000
        ];

        $this->assertJsonStringEqualsJsonString(
            json_encode($expectedData),
            $response->getContent()
        );
    }

    public function testGetBookError(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/books/' . 999999);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}
