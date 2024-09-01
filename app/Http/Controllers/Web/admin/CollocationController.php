<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollocationController extends Controller
{

     public function index()
     {
         $collections = Collection::paginate(10);
         return view('admin.collections.index', compact('collections'));
     }


     public function create()
     {
         return view('admin.collections.create');
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

         $collection = new Collection();
         $collection->name_en = $request->input('name_en');
         $collection->name_ar = $request->input('name_ar');
         $collection->description_en = $request->input('description_en');
         $collection->description_ar = $request->input('description_ar');

         if ($request->hasFile('image')) {



            $ProfileName = "FEE";
            $imageFile = $request->file('image');
            $imageUniqueName = uniqid();
            $imageExtension = $imageFile->getClientOriginalExtension();
            $imageFilename = $ProfileName . Carbon::now()->format('Ymd') . '_' . $imageUniqueName . '.' . $imageExtension;
            $imagePath = $imageFile->storeAs('public/upload/files/image/', $imageFilename);
            $imageUrl = Storage::url('upload/files/image/' . $imageFilename);

            $collection->image = $imageUrl;
        }


         $collection->save();

         return redirect()->route('admin.collections.index')->with('success', 'Collection created successfully.');
     }


     public function edit($id)
     {
        $collection=Collection::findOrFail($id);
         return view('admin.collections.edit', compact('collection'));
     }


     public function update(Request $request, $id)
     {
         $request->validate([
             'name_en' => 'nullable|string|max:255',
             'name_ar' => 'nullable|string|max:255',
             'description_en' => 'nullable|string',
             'description_ar' => 'nullable|string',
             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);
         $collection=Collection::findOrFail($id);
         $collection->name_en = $request->input('name_en');
         $collection->name_ar = $request->input('name_ar');
         $collection->description_en = $request->input('description_en');
         $collection->description_ar = $request->input('description_ar');

         if ($request->hasFile('image')) {

            if ($collection->image) {
                Storage::delete(str_replace('/storage', 'public', $collection->image));
            }

            $ProfileName = "FEE";
            $imageFile = $request->file('image');
            $imageUniqueName = uniqid();
            $imageExtension = $imageFile->getClientOriginalExtension();
            $imageFilename = $ProfileName . Carbon::now()->format('Ymd') . '_' . $imageUniqueName . '.' . $imageExtension;
            $imagePath = $imageFile->storeAs('public/upload/files/image/', $imageFilename);
            $imageUrl = Storage::url('upload/files/image/' . $imageFilename);

            $collection->image = $imageUrl;
        }


         $collection->save();

         return redirect()->route('admin.collections.index')->with('success', 'Collection updated successfully.');
     }


     public function destroy(Collection $collection)
     {
         if ($collection->image) {
             Storage::delete('public/' . $collection->image);
         }

         $collection->delete();

         return redirect()->route('admin.collections.index')->with('success', 'Collection deleted successfully.');
     }
}
