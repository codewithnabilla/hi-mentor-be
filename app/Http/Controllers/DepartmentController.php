<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Services\DepartmentService;
use Illuminate\Support\Facades\Gate;

class DepartmentController extends Controller
{
    public function __construct(
        protected DepartmentService $service
    ){}

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Department::class);

        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        return DepartmentResource::collection($this->service->getAll($perPage, $search));
    }

    public function store(StoreDepartmentRequest $request)
    {
        Gate::authorize('create', Department::class);

        $department = $this->service->create($request->validated());

        return new DepartmentResource($department);
    }

    public function show(Department $department)
    {
        Gate::authorize('view', $department);

        return new DepartmentResource($department);
    }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        Gate::authorize('update', $department);

        $department = $this->service->update($department, $request->validated());

        return new DepartmentResource($department);
    }

    public function destroy(Department $department)
    {
        Gate::authorize('delete', $department);

        $this->service->delete($department);

        return response()->noContent();
    }
}
