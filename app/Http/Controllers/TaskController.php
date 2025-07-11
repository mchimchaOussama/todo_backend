<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use App\Models\Task;
use App\Models\Notification;
use App\Events\TaskCreated;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        $tasks = $this->taskRepository->getUserTasks(auth()->user());
        return response()->json(['tasks' => $tasks]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = $this->taskRepository->createTask(
            auth()->user(),
            $request->all()
        );
        
        // Create notification
        $notification = auth()->user()->notifications()->create([
            'message' => "Tâche '{$task->title}' créée avec succès"
        ]);
        
        // Broadcast event
        event(new TaskCreated($task, $notification));

        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'sometimes|boolean',
        ]);

        $task = $this->taskRepository->updateTask($task, $request->all());
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $this->taskRepository->deleteTask($task);
        return response()->json(null, 204);
    }
}