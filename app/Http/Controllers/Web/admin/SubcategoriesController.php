<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubcategoriesController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->get();
        return view('admin.subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image',
        ]);

        try{

        $subcategory = new Subcategory($request->only('name', 'name_ar', 'description', 'description_ar', 'category_id'));

        if ($request->hasFile('image')) {



            $ProfileName = "FEE";
            $imageFile = $request->file('image');
            $imageUniqueName = uniqid();
            $imageExtension = $imageFile->getClientOriginalExtension();
            $imageFilename = $ProfileName . Carbon::now()->format('Ymd') . '_' . $imageUniqueName . '.' . $imageExtension;
            $imagePath = $imageFile->storeAs('public/upload/files/image/', $imageFilename);
            $imageUrl = Storage::url('upload/files/image/' . $imageFilename);

            $subcategory->image = $imageUrl;
        }

        $subcategory->save();

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory created successfully!');

    }catch(\Exception $e){
        return redirect()->route('admin.subcategories.create')->with('success',$e);
    }
    }

    public function edit($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $subcategory = Subcategory::findOrFail($id);

        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image',
        ]);

        $subcategory->update($request->only('name_en', 'name_ar', 'description_en', 'description_ar', 'category_id'));

        if ($request->hasFile('image')) {

            if ($subcategory->image) {
                Storage::delete(str_replace('/storage', 'public', $subcategory->image));
            }

            $ProfileName = "FEE";
            $imageFile = $request->file('image');
            $imageUniqueName = uniqid();
            $imageExtension = $imageFile->getClientOriginalExtension();
            $imageFilename = $ProfileName . Carbon::now()->format('Ymd') . '_' . $imageUniqueName . '.' . $imageExtension;
            $imagePath = $imageFile->storeAs('public/upload/files/image/', $imageFilename);
            $imageUrl = Storage::url('upload/files/image/' . $imageFilename);

            $subcategory->image = $imageUrl;
        }

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory updated successfully!');
    }

    public function destroy($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->delete();
        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory deleted successfully!');
    }
}
