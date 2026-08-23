<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(
        protected PermissionService $service
    ) {}

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        return PermissionResource::collection(
            $this->service->getAll($perPage)
        );
    }

    public function store(StorePermissionRequest $request)
    {
        return new PermissionResource(
            $this->service->create($request->validated())
        );
    }

    public function show(Permission $permission)
    {
        return new PermissionResource($permission);
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        return new PermissionResource(
            $this->service->update($permission, $request->validated())
        );
    }

    public function destroy(Permission $permission)
    {
        $this->service->delete($permission);

        return response()->json([
            'message' => 'Permission deleted successfully.'
        ]);
    }
}
