<?php

namespace App\Services;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;


class AuthorService
{
    public function __construct(
        protected AuthorRepository $authorRepository,
        protected SerializerInterface $serializer
    ) {}

    /**
     * @return JsonResponse
     */
    public function getAllAuthors(): Response
    {
        $authors = $this->authorRepository->getAllAuthors();

        if (empty($authors)) {
            return new JsonResponse(['error' => 'No authors found.'], Response::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($authors, 'json');
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    public function createAuthor(array $data, EntityManagerInterface $entityManager)
    {
        if(!$data) {
            return new JsonResponse(['error' => 'Отсутствуют данные для создания автора'], Response::HTTP_BAD_REQUEST);
        }
        $author = new Author();
        $author->setName($data['name']);
        $author->setSurname($data['surname']);
        $author->setPatronymic($data['patronymic']);

        $entityManager->persist($author);
        $entityManager->flush();
        return new JsonResponse(['message' => 'Автор успешно создан'], Response::HTTP_OK);
    }
}
