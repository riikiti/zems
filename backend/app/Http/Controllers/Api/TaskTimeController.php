<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskTime\ShowTaskTimeRequest;
use App\Http\Requests\TaskTime\TaskTimeRequest;
use App\Http\Requests\TaskTime\TaskTimeStoreRequest;
use App\Http\Resources\TaskTimeResource;
use App\Models\TaskTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TaskTimeController extends Controller
{
    public function index(ShowTaskTimeRequest $request)
    {
        return response()->json(['status' => 'success', 'data' => TaskTimeResource::collection(TaskTime::createdAt()->where('task_id', $request->task_id)->get())]);
    }

    public function store(TaskTimeStoreRequest $request)
    {
        return response()->json(['status' => 'success', 'data' => TaskTimeResource::make(TaskTime::create($request->validated()))]);
    }

    public function destroy(TaskTime $time)
    {
        $time->delete();
        return response()->json(['status' => 'success', 'data' => []]);
    }
}
