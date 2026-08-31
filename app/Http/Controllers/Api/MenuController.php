<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MenuController extends Controller
{
    public function __construct(
        protected MenuService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Menu::class);

        return MenuResource::collection(
            $this->service->getVisibleFor($request->user(), $request->input('search'))
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        Gate::authorize('create', Menu::class);

        return new MenuResource(
            $this->service->create($request->validated())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        Gate::authorize('view', Menu::class);

        return new MenuResource(
            $menu->load('children')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        Gate::authorize('update', $menu);

        return new MenuResource(
            $this->service->update($menu, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        Gate::authorize('delete', $menu);
        
        $this->service->delete($menu);

        return response()->json([
            'message' => 'Menu deleted successfully.'
        ]);
    }
}
