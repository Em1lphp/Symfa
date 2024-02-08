<?php

namespace App\Services;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @return JsonResponse
     */
    public function getAllBooks(): Response
    {
        $books = $this->bookRepository->getBook();

        if (!$books) {
            return new JsonResponse(['error' => 'No books found.'], Response::HTTP_NOT_FOUND);
        }

        $booksArray = [];
        foreach ($books as $book) {
            $bookArray = [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'description' => $book->getDescription(),
                'image' => $book->getImage(),
                'publishedAt' => $book->getPublishedAt(),
                'authors' => $this->getAuthorsArray($book->getAuthors()),
            ];
            $booksArray[] = $bookArray;
        }

        $json = $this->serializer->serialize($booksArray, 'json');
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /**
     * @param $authors
     * @return array
     */
    private function getAuthorsArray($authors): array
    {
        $authorsArray = [];
        foreach ($authors as $author) {
            $authorsArray[] = [
                'id' => $author->getId(),
                'name' => $author->getName(),
                'surname' => $author->getSurname(),
            ];
        }
        return $authorsArray;
    }
}
