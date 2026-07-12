<?php

namespace App\Services;

use App\Models\Menu;

class MenuService
{
    public function getAll()
    {
        return Menu::with('children')
            ->whereNull('parent_uuid')
            ->orderBy('order')
            ->get();
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
