<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with(['parent', 'children'])
            ->root()
            ->ordered()
            ->get();

        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentMenus = Menu::active()->root()->ordered()->get();
        return view('admin.menus.create', compact('parentMenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:menus,slug',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:menus,id',
            'sort_order' => 'integer|min:0',
            'target' => 'required|in:_self,_blank',
            'status' => 'required|in:active,inactive',
            'position' => 'required|in:header,footer,sidebar'
        ]);

        // Tự động tạo slug nếu không có
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Đảm bảo slug là duy nhất
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Menu::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        Menu::create($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        $menu->load(['parent', 'children.children']);
        return view('admin.menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $parentMenus = Menu::active()
            ->where('id', '!=', $menu->id)
            ->root()
            ->ordered()
            ->get();

        return view('admin.menus.edit', compact('menu', 'parentMenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('menus', 'slug')->ignore($menu->id)
            ],
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => [
                'nullable',
                'exists:menus,id',
                function ($attribute, $value, $fail) use ($menu) {
                    // Không thể đặt chính nó làm parent
                    if ($value == $menu->id) {
                        $fail('Menu không thể là parent của chính nó.');
                    }
                    
                    // Không thể đặt menu con làm parent
                    if ($value && $menu->children()->where('id', $value)->exists()) {
                        $fail('Không thể đặt menu con làm parent.');
                    }
                }
            ],
            'sort_order' => 'integer|min:0',
            'target' => 'required|in:_self,_blank',
            'status' => 'required|in:active,inactive',
            'position' => 'required|in:header,footer,sidebar'
        ]);

        // Tự động tạo slug nếu không có
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Đảm bảo slug là duy nhất (ngoại trừ menu hiện tại)
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Menu::where('slug', $validated['slug'])->where('id', '!=', $menu->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $menu->update($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // Kiểm tra xem menu có con không
        if ($menu->hasChildren()) {
            return back()->with('error', 'Không thể xóa menu có menu con. Vui lòng xóa menu con trước.');
        }

        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu đã được xóa thành công!');
    }

    /**
     * Cập nhật thứ tự menu
     */
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menus,id',
            'items.*.sort_order' => 'required|integer|min:0',
            'items.*.parent_id' => 'nullable|exists:menus,id'
        ]);

        foreach ($validated['items'] as $item) {
            Menu::where('id', $item['id'])->update([
                'sort_order' => $item['sort_order'],
                'parent_id' => $item['parent_id']
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Thứ tự menu đã được cập nhật!']);
    }

    /**
     * Thay đổi trạng thái menu
     */
    public function toggleStatus(Menu $menu)
    {
        $menu->update([
            'status' => $menu->status === 'active' ? 'inactive' : 'active'
        ]);

        $status = $menu->status === 'active' ? 'kích hoạt' : 'vô hiệu hóa';

        return back()->with('success', "Menu đã được {$status} thành công!");
    }

    /**
     * Lấy menu theo AJAX
     */
    public function getMenusAjax(Request $request)
    {
        $position = $request->get('position', 'header');
        
        $menus = Menu::with(['children.children'])
            ->byPosition($position)
            ->active()
            ->root()
            ->ordered()
            ->get();

        return response()->json($menus);
    }
}
