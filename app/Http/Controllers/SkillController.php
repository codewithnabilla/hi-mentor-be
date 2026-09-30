<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use App\Services\SkillService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SkillController extends Controller
{
    public function __construct(
        protected SkillService $service
    ) {}

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Skill::class);

        return SkillResource::collection($this->service->getAll(
            $request->input('per_page', 10),
            $request->input('search')
        ));
    }

    public function store(StoreSkillRequest $request)
    {
        Gate::authorize('create', Skill::class);

        return new SkillResource($this->service->create($request->validated()));
    }

    public function show(Skill $skill)
    {
        Gate::authorize('view', $skill);

        return new SkillResource($skill);
    }

    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        Gate::authorize('update', $skill);

        return new SkillResource($this->service->update($skill, $request->validated()));
    }

    public function destroy(Skill $skill)
    {
        Gate::authorize('delete', $skill);
        $this->service->delete($skill);

        return response()->noContent();
    }
}