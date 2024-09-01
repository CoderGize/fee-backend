<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
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
        $request->validate([
            'name_en' => 'nullable|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try{

        $category = new Category();
        $category->name = $request->input('name_en');
        $category->name_ar = $request->input('name_ar');
        $category->description = $request->input('description_en');
        $category->description_ar = $request->input('description_ar');

        if ($request->hasFile('image')) {



            $ProfileName = "FEE";
            $imageFile = $request->file('image');
            $imageUniqueName = uniqid();
            $imageExtension = $imageFile->getClientOriginalExtension();
            $imageFilename = $ProfileName . Carbon::now()->format('Ymd') . '_' . $imageUniqueName . '.' . $imageExtension;
            $imagePath = $imageFile->storeAs('public/upload/files/image/', $imageFilename);
            $imageUrl = Storage::url('upload/files/image/' . $imageFilename);

            $category->image = $imageUrl;
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
        }catch(\Exception $e){
            return redirect()->route('admin.categories.index')->with('error', $e);

        }
    }

    public function edit($id)
    {
        $category=Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name_en' => 'nullable|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
        ]);

        $category=Category::findOrFail($id);

        try{

        $category->name = $request->input('name_en');
        $category->name_ar = $request->input('name_ar');
        $category->description = $request->input('description_en');
        $category->description_ar = $request->input('description_ar');

        if ($request->hasFile('image')) {

            if ($category->image) {
                Storage::delete(str_replace('/storage', 'public', $category->image));
            }

            $ProfileName = "FEE";
            $imageFile = $request->file('image');
            $imageUniqueName = uniqid();
            $imageExtension = $imageFile->getClientOriginalExtension();
            $imageFilename = $ProfileName . Carbon::now()->format('Ymd') . '_' . $imageUniqueName . '.' . $imageExtension;
            $imagePath = $imageFile->storeAs('public/upload/files/image/', $imageFilename);
            $imageUrl = Storage::url('upload/files/image/' . $imageFilename);

            $category->image = $imageUrl;
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');

        }catch(\Exception $e){
            return redirect()->route('admin.categories.index')->with('error', $e);
        }
    }

    public function destroy($id)
    {
        $category=Category::findOrFail($id);
        if ($category->image) {
            Storage::delete('public/' . $category->image);
        }
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
