<?php

namespace App\Controller\API;

use App\Services\BookService;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
}
