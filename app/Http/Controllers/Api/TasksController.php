<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreTaskRequest;
use App\Http\Requests\Api\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = Task::query()
            ->latest()
            ->get()
            ->map(function($task) {
                return [
                    'id' => $task -> uuid,
                    'name' => $task -> name,
                    'description' => $task -> description,
                    'created_at' => [
                        'date' => $task -> created_at -> format('F j, Y'),
                        'time' => $task -> created_at -> format('h:ia')
                    ]
                ];
            });

        return response() -> json([
            'tasks' => $tasks
        ]);;
    }

    public function store(StoreTaskRequest $request) {
        $message = "";  

        try {
            $task = Task::create([
                'uuid' => str_replace("-", '', Str::uuid()),
                'name' => $request -> name,
                'description' => $request -> description,
                'creator_id' => 1
            ]);

            $message = 'Successfully created new task';

        } catch (\Exception $e) {
            $message = $e -> getMessage();
        }

        return response() -> json([
            'message' => $message
        ]);
    }

    public function update(Task $task, UpdateTaskRequest $request) {
        $message = "";  

        try {
            $task->update([
                'name' => $request -> name,
                'description' => $request -> description,
            ]);

            $message = 'Successfully updated task details.';

        } catch (\Exception $e) {
            $message = $e -> getMessage();
        }

        return response() -> json([
            'message' => $message
        ]);
    }

    public function destroy(Task $task) 
    {
        $message = "";  

        try {
            $task->delete();

            $message = 'Successfully deleted task details.';

        } catch (\Exception $e) {
            $message = $e -> getMessage();
        }

        return response() -> json([
            'message' => $message
        ]);
    }
}  
