<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required | min: 1 | max: 149',
            'image' => 'required | image | max: 2048',
            'description' => 'max: 1500',
        ]);
        DB::beginTransaction();
        try {
            $originalSlug = Str::slug($data['name'], '-');
            $slug = $originalSlug;
            $count = 1;
            $slugExists = (bool) Category::where('slug', $slug)->first();

            $order = Category::max('display_order') + 1;
            while ($slugExists) {
                $slug = $originalSlug.'-'.$count;
                $slugExists = (bool) Category::where('slug', $slug)->first();
                $count = $count + 1;
            }

            $image = $request->file('image');
            $imageName = $slug.'-'.uniqid().'.'.$image->extension();
            $image->move(storage_path('app/public/images/categories'), $imageName);

            $data['image'] = 'storage/images/categories/'.$imageName;
            $data['slug'] = $slug;
            $data['display_order'] = $order;
            Category::create($data);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return back()->withErrors('Failed to create new category');
        }

        return redirect()->route('admin.category.index')->with('success', 'Category Added Successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required | min: 1 | max: 149',
            'image' => 'image | max: 2048',
            'description' => 'max: 1500',
            'display_order' => 'required | numeric | min: 0',
        ]);
        DB::beginTransaction();
        try {
            $originalSlug = Str::slug($data['name'], '-');
            $slug = $originalSlug;
            $count = 1;
            $slugExists = (bool) Category::where('slug', $slug)->where('id', '<>', $category->id)->first();
            while ($slugExists) {
                $slug = $originalSlug.'-'.$count;
                $slugExists = (bool) Category::where('slug', $slug)->first();
                $count = $count + 1;
            }

            if ($request->has('image')) {
                $image = $request->file('image');
                $imageName = $slug.'-'.uniqid().'.'.$image->extension();
                $image->move(storage_path('app/public/images/categories'), $imageName);
                $data['image'] = 'storage/images/categories/'.$imageName;
            }

            $data['slug'] = $slug;
            $category->update($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return back()->withErrors('Failed to update category');
        }

        return redirect()->route('admin.category.index')->with('success', 'Category Updated Successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Item Deleted Successfully');
    }
}
