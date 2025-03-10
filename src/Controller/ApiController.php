<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiController extends AbstractController
{
    public function __construct(
        private readonly TaskRepository         $taskRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly SerializerInterface    $serializer

    )
    {

    }

    #[Route('/api/tasks', methods: ['GET'])]
    public function task(): JsonResponse
    {
        $tasks = $this->taskRepository->findAll();
        $data = $this->serializer->serialize($tasks, 'json');
        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/api/task/{id}', methods: ['GET'])]
    public function taskById(int $id): JsonResponse
    {
        $task = $this->taskRepository->find($id);
        $data = $this->serializer->serialize($task, 'json');
        return new JsonResponse($data, 200, [], true);
    }


}
