<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Permission;
use App\Models\User;
use App\Services\PermissionService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct(
        protected UserService $service
    ) {}

    public function index(Request $request)
    {
        Gate::authorize('viewAny', User::class);

        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        return UserResource::collection(
            $this->service->getAll($perPage, $search)
        );
    }

    public function store(StoreUserRequest $request)
    {
        Gate::authorize('create', User::class);

        return (new UserResource(
            $this->service->create($request->validated())
        ))->response()->setStatusCode(201);
    }

    public function show(User $user)
    {
        Gate::authorize('view', User::class);

        return new UserResource($user->load('roles.permissions'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        Gate::authorize('update', User::class);

        return new UserResource(
            $this->service->update($user, $request->validated())
        );
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete', User::class);

        $this->service->delete($user);

        return response()->json([
            'message' => 'User deleted successfully.'
        ]);
    }
}
