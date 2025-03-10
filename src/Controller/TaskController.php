<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TaskController extends AbstractController
{

    public function __construct(
        private readonly TaskRepository $taskRepository,
        private readonly EntityManagerInterface  $entityManager
    )
    {
    }

    #[Route('/', name: 'app_task')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $this->taskRepository->findAll(),
        ]);
    }

    #[Route('/task/{id}/edit', name: 'app_task_edit')]
    public function edit(Task $task, Request $request): Response
    {
        $taskForm = $this->createForm(TaskType::class, $task);
        $taskForm->handleRequest($request);
        if ($taskForm->isSubmitted() && $taskForm->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('app_task');
        }

        return $this->render('task/edit.html.twig', [
            'taskForm' => $taskForm,
        ]);
    }

    #[Route('/task/{id}/delete', name: 'app_task_delete')]
    public function delete(Task $task): Response
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_task');
    }

    #[Route('/task/add', name: 'app_task_add')]
    public function add(
        Request $request
    ): Response
    {
        $task = new Task();
        $taskForm = $this->createForm(TaskType::class, $task);
        $taskForm->handleRequest($request);
        if ($taskForm->isSubmitted() && $taskForm->isValid()) {
            $this->entityManager->persist($task);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_task');
        }
        return $this->render('task/edit.html.twig', [
            'controller_name' => 'TaskController',
            'taskForm' => $taskForm,
        ]);
    }
}
