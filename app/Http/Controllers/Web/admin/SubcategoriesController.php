<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class SubcategoriesController extends Controller
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
        $subcategories = Subcategory::with('category')->get();
        $categories = Category::all();
        return view('admin.subcategories.index', compact('subcategories', 'categories'));
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

        $image = $request->file('image');

        if ($image)
        {
            $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $filename = '/fee/subcategory/' . $hashed_image;
            $imageContent = file_get_contents($image->getPathname());

            $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => 'application/octet-stream',
                ],
                'body' => $imageContent,
            ]);

            $subcategory->image = 'https://hooray-lb.sirv.com/fee/subcategory/' . $hashed_image;
        }

        $subcategory->save();



        return redirect()->back()->with('message', 'Subcategory created successfully!');

    }catch(\Exception $e){
        return redirect()->back()->with('error',$e->getMessage());
    }
    }

    public function edit($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    // public function update(Request $request, $id)
    // {
    //     $subcategory = Subcategory::findOrFail($id);

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'name_ar' => 'nullable|string|max:255',
    //         'description' => 'nullable|string',
    //         'description_ar' => 'nullable|string',
    //         'category_id' => 'required|exists:categories,id',
    //         'image' => 'nullable|image',
    //     ]);

    //     $subcategory = $subcategory->update($request->only('name', 'name_ar', 'description', 'description_ar', 'category_id'));

    //     $image = $request->file('image');

    //     if ($image)
    //     {
    //         $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
    //         $filename = '/fee/subcategory/' . $hashed_image;
    //         $imageContent = file_get_contents($image->getPathname());

    //         $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . $this->token,
    //                 'Content-Type' => 'application/octet-stream',
    //             ],
    //             'body' => $imageContent,
    //         ]);

    //         $subcategory->image = 'https://hooray-lb.sirv.com/fee/subcategory/' . $hashed_image;
    //     }

    //     $subcategory->save();

    //     return redirect()->back()->with('message', 'Subcategory updated successfully!');
    // }

    public function destroy($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->delete();
        return redirect()->route('admin.subcategories.index')->with('message', 'Subcategory deleted successfully!');
    }

    public function update(Request $request, $id)
    {
        try
        {
            $subcategory = Subcategory::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'name_ar' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image',
            ]);

            $subcategory->update($request->only('name', 'name_ar', 'description', 'description_ar', 'category_id'));

            $image = $request->file('image');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/subcategory/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $subcategory->image = 'https://hooray-lb.sirv.com/fee/subcategory/' . $hashed_image;
            }

            $subcategory->save();

            return redirect()->back()->with('message', 'Subcategory updated successfully!');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
