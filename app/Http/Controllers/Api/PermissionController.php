<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    public function __construct(
        protected PermissionService $service
    ) {}

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Permission::class);

        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        return PermissionResource::collection(
            $this->service->getAll($perPage, $search)
        );
    }

    public function store(StorePermissionRequest $request)
    {
        Gate::authorize('create', Permission::class);

        return new PermissionResource(
            $this->service->create($request->validated())
        );
    }

    public function show(Permission $permission)
    {
        Gate::authorize('view', $permission);

        return new PermissionResource($permission);
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        Gate::authorize('update', $permission);

        return new PermissionResource(
            $this->service->update($permission, $request->validated())
        );
    }

    public function destroy(Permission $permission)
    {
        Gate::authorize('delete', $permission);

        $this->service->delete($permission);

        return response()->json([
            'message' => 'Permission deleted successfully.'
        ]);
    }
}
