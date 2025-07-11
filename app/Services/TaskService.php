<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Models\Notification;
use App\Events\TaskCreated;
use App\Repositories\TaskRepository;

class TaskService
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getTasksForUser(User $user)
    {
        return $this->taskRepository->getUserTasks($user);
    }

    public function createTaskForUser(User $user, array $data)
    {
        $task = $this->taskRepository->createTask($user, $data);

        $notification = $user->notifications()->create([
            'message' => "Tâche '{$task->title}' créée avec succès"
        ]);

        event(new TaskCreated($task, $notification));

        return $task;
    }

    public function updateTask(Task $task, array $data)
    {
        return $this->taskRepository->updateTask($task, $data);
    }

    public function deleteTask(Task $task)
    {
        return $this->taskRepository->deleteTask($task);
    }
}
