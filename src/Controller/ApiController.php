<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/api/task', methods: ['POST'])]
    public function addTask(Request $request): JsonResponse
    {
        $data = $request->getContent();
        $task = $this->serializer->deserialize($data, Task::class, 'json');
        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return new JsonResponse($this->serializer->serialize($task, 'json'), 201, []);
    }

    #[Route('/api/task/{id}', methods: ['PUT'])]
    public function updateTask(Task $task, Request $request): JsonResponse
    {
        $data = $request->getContent();

        $updatedTask = $this->serializer->deserialize($data, Task::class, 'json', ['object_to_populate' => $task]);
        $this->entityManager->flush();

        return new JsonResponse($this->serializer->serialize($task, 'json'), 200, []);
    }

    #[Route('/api/task/{id}', methods: ['DELETE'])]
    public function deleteTask(Task $task): JsonResponse
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();

        return new JsonResponse(null, 204, []);
    }


}
