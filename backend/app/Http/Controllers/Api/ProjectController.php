<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectRequest;
use App\Http\Requests\Project\ProjectStoreRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => ProjectResource::collection(Project::query()->where('user_id', auth()->id())->paginate(6))->response()->getData(),
        ]);
    }

    public function store(ProjectStoreRequest $request)
    {
        return response()->json(['status' => 'success', 'data' => ProjectResource::make(Project::create(array_merge($request->validated(), ['user_id' => auth()->id()])))]);
    }

    public function show(Project $project)
    {
        return response()->json(['status' => 'success', 'data' => ProjectResource::make($project)]);
    }


    public function update(ProjectRequest $request, Project $project)
    {
        $project->fill($request->validated())->save();
        return response()->json(['status' => 'success', 'data' => ProjectResource::make($project)]);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(['status' => 'success', 'data' => []]);
    }
}
