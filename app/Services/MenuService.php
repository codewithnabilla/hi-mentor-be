<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class MenuService
{
    public function getVisibleFor(User $user): Collection
    {
        $menus = Menu::with('children.children')
            ->where('is_active', true)
            ->whereNull('parent_uuid')
            ->orderBy('order')
            ->get();

        return $this->filterVisibleMenus($menus, $user);
    }

    private function filterVisibleMenus(Collection $menus, User $user): Collection
    {
        return $menus->filter(function (Menu $menu) use ($user): bool {
            if (!$menu->is_active) {
                return false;
            }

            $visibleChildren = $this->filterVisibleMenus(
                $menu->children,
                $user
            );

            $menu->setRelation('children', $visibleChildren->values());

            $hasPermission = blank($menu->permission)
                ? $visibleChildren->isNotEmpty()
                : $user->can($menu->permission);

            return $hasPermission && ($visibleChildren->isNotEmpty() || filled($menu->permission));
        })->values();
    }

    public function create(array $data)
    {
        return Menu::create($data);
    }

    public function update(Menu $menu, array $data)
    {
        $menu->update($data);

        return $menu;
    }

    public function delete(Menu $menu)
    {
        $menu->delete();
    }
}
