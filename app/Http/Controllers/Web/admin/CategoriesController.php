<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class CategoriesController extends Controller
{
    protected $client;
    protected $token;

    public function __construct()
    {
        $this->client = new Client();

        $response = $this->client->post('https://api.sirv.com/v2/token', [
            'json' => [
                'clientId' => env('SIRV_CLIENT_ID'),
                'clientSecret' => env('SIRV_CLIENT_SECRET'),
            ],
        ]);

        $this->token = json_decode($response->getBody()->getContents())->token;
    }

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

        $image = $request->file('img');

        if ($image)
        {
            $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $filename = '/fee/category/' . $hashed_image;
            $imageContent = file_get_contents($image->getPathname());

            $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => 'application/octet-stream',
                ],
                'body' => $imageContent,
            ]);

            $category->image = 'https://hooray-lb.sirv.com/fee/category/' . $hashed_image;
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('message', 'Category created successfully.');
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

        $image = $request->file('img');

        if ($image)
        {
            $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $filename = '/fee/category/' . $hashed_image;
            $imageContent = file_get_contents($image->getPathname());

            $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => 'application/octet-stream',
                ],
                'body' => $imageContent,
            ]);

            $category->image = 'https://hooray-lb.sirv.com/fee/category/' . $hashed_image;
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('message', 'Category updated successfully.');

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

        return redirect()->route('admin.categories.index')->with('message', 'Category deleted successfully.');
    }
}
