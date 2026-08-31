<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function __construct(
        protected RoleService $service
    ) {}

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Role::class);

        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        return RoleResource::collection(
            $this->service->getAll($perPage, $search)
        );
    }

    public function store(StoreRoleRequest $request)
    {
        Gate::authorize('create', Role::class);

        return new RoleResource(
            $this->service->create($request->validated())
        );
    }

    public function show(Role $role)
    {
        Gate::authorize('view', $role);

        return new RoleResource(
            $role->load('permissions')
        );
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        Gate::authorize('update', $role);

        return new RoleResource(
            $this->service->update($role, $request->validated())
        );
    }

    public function destroy(Role $role)
    {
        Gate::authorize('delete', $role);

        $this->service->delete($role);

        return response()->json([
            'message' => 'Role deleted successfully.'
        ]);
    }

    public function assignPermissions(Request $request, Role $role)
    {
        Gate::authorize('update', $role);

        $validated = $request->validate([
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'string', 'exists:permissions,uuid'],
        ]);

        return new RoleResource(
            $this->service->assignPermissions($role, $validated['permissions'])
        );
    }
}
