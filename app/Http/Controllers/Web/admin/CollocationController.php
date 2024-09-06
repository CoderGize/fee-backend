<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class CollocationController extends Controller
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

         $image = $request->file('img');

        if ($image)
        {
            $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $filename = '/fee/collection/' . $hashed_image;
            $imageContent = file_get_contents($image->getPathname());

            $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => 'application/octet-stream',
                ],
                'body' => $imageContent,
            ]);

            $collection->image = 'https://hooray-lb.sirv.com/fee/collection/' . $hashed_image;
        }


         $collection->save();

         return redirect()->route('admin.collections.index')->with('message', 'Collection created successfully.');
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

         $image = $request->file('img');

         if ($image)
         {
             $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
             $filename = '/fee/collection/' . $hashed_image;
             $imageContent = file_get_contents($image->getPathname());

             $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                 'headers' => [
                     'Authorization' => 'Bearer ' . $this->token,
                     'Content-Type' => 'application/octet-stream',
                 ],
                 'body' => $imageContent,
             ]);

             $collection->image = 'https://hooray-lb.sirv.com/fee/collection/' . $hashed_image;
         }


         $collection->save();

         return redirect()->route('admin.collections.index')->with('message', 'Collection updated successfully.');
     }


     public function destroy($id)
     {
        try
        {
            $collection=Collection::findOrFail($id);

            $collection->delete();

            return redirect()->back()->with('message', 'Collection deleted successfully.');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
     }
}
