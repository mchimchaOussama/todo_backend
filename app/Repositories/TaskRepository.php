<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;

class TaskRepository
{
    public function getUserTasks(User $user)
    {
        return $user->tasks;
    }

    public function createTask(User $user, array $data)
    {
        return $user->tasks()->create($data);
    }

    public function updateTask(Task $task, array $data)
    {
        $task->update($data);
        return $task;
    }

    public function deleteTask(Task $task)
    {
        $task->delete();
    }
}