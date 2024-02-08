<?php

namespace App\Services;

use App\Entity\Author;
use App\Entity\Book;
use App\Repository\BookRepository;

use DateTimeImmutable;

use Doctrine\ORM\EntityManagerInterface;

use Exception as ExceptionAlias;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;


class BookService
{
    public function __construct(
        protected BookRepository $bookRepository,
        protected SerializerInterface $serializer
    ) {}

    /**
     * @return Response|array
     */
    public function getAllBooks(): Response|array
    {
        $books = $this->bookRepository->getBook();

        if (!$books) {
            return new JsonResponse(['error' => 'No books found.'], Response::HTTP_NOT_FOUND);
        }

        $results = $this->serializer->serialize($books, 'json', ['groups' => 'book']);
        $response = new Response($results);
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        return $response;
    }

    /**
     * @param array $data
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     * @throws ExceptionAlias
     */
    public function createBook(array $data, EntityManagerInterface $entityManager)
    {
        if (!$data) {
            return new JsonResponse(['error' => 'Отсутствуют данные для создания'], Response::HTTP_BAD_REQUEST);
        }

        $book = new Book();
        $book->setTitle($data['title']);
        $book->setDescription($data['description'] ?? null);
        $book->setImage($data['image']);
        $book->setPublishedAt(new DateTimeImmutable($data['publishedAt']));


        $author = new Author();
        $author->setName($data['name']);
        $author->setSurname($data['surname']);
        $author->setPatronymic($data['patronymic'] ?? null);

        $author->addBook($book);

        $entityManager->persist($book);
        $entityManager->persist($author);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Книга и автор успешно созданы'], Response::HTTP_OK);
    }
}
