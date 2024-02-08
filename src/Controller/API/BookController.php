<?php

namespace App\Controller\API;

use App\Services\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    public function __construct(
        protected BookService $bookService
    ) {}
    #[Route('/books', name: 'books_index')]
    public function getAllBooksAction(): JsonResponse
    {
        return $this->bookService->getAllBooks();
    }
}
