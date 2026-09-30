<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCareerRequest;
use App\Http\Requests\UpdateCareerRequest;
use App\Http\Resources\CareerResource;
use App\Models\Career;
use App\Services\CareerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CareerController extends Controller
{
    public function __construct(
        protected CareerService $service
    ) {}

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Career::class);

        return CareerResource::collection($this->service->getAll(
            $request->input('per_page', 10),
            $request->input('search')
        ));
    }

    public function store(StoreCareerRequest $request)
    {
        Gate::authorize('create', Career::class);

        return new CareerResource($this->service->create($request->validated()));
    }

    public function show(Career $career)
    {
        Gate::authorize('view', $career);

        return new CareerResource($career);
    }

    public function update(UpdateCareerRequest $request, Career $career)
    {
        Gate::authorize('update', $career);

        return new CareerResource($this->service->update($career, $request->validated()));
    }

    public function destroy(Career $career)
    {
        Gate::authorize('delete', $career);
        $this->service->delete($career);

        return response()->noContent();
    }
}