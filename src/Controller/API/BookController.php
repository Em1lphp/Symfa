<?php

namespace App\Controller\API;

use App\Repository\BookRepository;
use App\Services\BookService;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class BookController extends AbstractController
{
    public function __construct(
        protected BookService $bookService
    ) {}
    #[Route('/books', name: 'books_index')]
    public function getAllBooksAction(): Response|array
    {
        return $this->bookService->getAllBooks();
    }

    #[Route( path:'/book/create', name: 'create_author', methods: ['POST'])]
    public function createAuthorAction(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        return $this->bookService->createBook($data, $entityManager);
    }

    #[Route('/book/by-author/{surname}', name: 'books_by_author', methods: ['GET'])]
    public function findByAuthor(
        BookRepository $repository,
        SerializerInterface $serializer,
        string $surname
    ): JsonResponse {
        $books = $repository->findByAuthorSurname($surname);

        if (empty($books)) {
            return $this->json('No books found for author with surname ' . $surname, 404);
        }

        $data = $serializer->normalize(
            $books,
            null,
            ['attributes' => ['id', 'title', 'description']]
        );

        return $this->json($data, Response::HTTP_OK, ['json_encode_options' => JSON_THROW_ON_ERROR]);
    }
}
