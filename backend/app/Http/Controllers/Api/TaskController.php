<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskIndexRequest;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    public function index(TaskIndexRequest $request)
    {
        return response()->json(['status' => 'success', 'data' => TaskResource::collection(Task::query()->where('project_id', $request->project_id)->paginate(6))->response()->getData()]);
    }

    public function store(TaskStoreRequest $request)
    {
        return response()->json(['status' => 'success', 'data' => TaskResource::make(Task::create($request->validated()))]);
    }

    public function show(Task $task)
    {
        return response()->json(['status' => 'success', 'data' => TaskResource::make($task)]);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task->fill($request->validated())->save();
        return response()->json(['status' => 'success', 'data' => TaskResource::make($task)]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['status' => 'success', 'data' => []]);
    }
}
