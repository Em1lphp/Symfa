<?php

namespace App\Controller\API;

use App\Services\AuthorService;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
class AuthorController extends AbstractController
{
    public function __construct(
        protected AuthorService $authorService
    ) {}


    #[Route(path:'/authors', name: 'authors_index',methods: ['GET'])]
    public function getAllAuthorsAction(): JsonResponse
    {
        return $this->authorService->getAllAuthors();
    }

    #[Route( path:'/author/create', name: 'create_author', methods: ['POST'])]
    public function createAuthorAction(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        return $this->authorService->createAuthor($data, $entityManager);
    }
}
