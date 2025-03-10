<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private $data = [
        [
            'title' => 'Task 1',
            'description' => 'Description 1',
            'status' => 'pending',
            'created_at' => '2021-01-01 00:00:00',
        ],
        [
            'title' => 'Task 2',
            'description' => 'Description 2',
            'status' => 'pending',
            'created_at' => '2021-01-02 00:00:00',
        ],
        [
            'title' => 'Task 3',
            'description' => 'Description 3',
            'status' => 'pending',
            'created_at' => '2021-01-03 00:00:00',
        ],
    ];

    /**
     * @throws \DateMalformedStringException
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->data as $item) {
            $task = new Task();
            $task->setTitle($item['title']);
            $task->setDescription($item['description']);
            $task->setStatus($item['status']);
            $task->setCreatedAt(new \DateTimeImmutable($item['created_at']));


            $manager->persist($task);
        }

        $manager->flush();
    }
}
