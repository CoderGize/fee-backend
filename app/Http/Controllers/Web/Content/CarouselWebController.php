<?php

namespace App\Http\Controllers\Web\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\Carousel;
use App\Models\Show;
use App\Models\Product;

class CarouselWebController extends Controller
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

    public function show_carousel()
    {
        $carousel = Carousel::latest()->paginate(10);

        $show = Show::find(1);

        $product = Product::all();
        return view('admin.web.carousel.show_carousel', compact('carousel', 'show', 'product'));
    }

    public function add_carousel(Request $request)
    {
        try
        {
            $carousel = new Carousel;

            $product = Product::find($request->product_1_id);

            $image = $request->file('img');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/carousel/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $carousel->img = 'https://hooray-lb.sirv.com/fee/carousel/' . $hashed_image;
            }

            $carousel->product_id = $product->id;
            $carousel->title_en = $product->name;
            $carousel->title_ar = $product->name_ar;

            $carousel->save();

            return redirect()->back()->with('message', 'Carousel Item Added');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update_carousel(Request $request, $id)
    {
        try
        {
            $carousel = Carousel::find($id);

            $product = Product::find($request->product_1_id);

            $image = $request->file('img');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/carousel/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $carousel->img = 'https://hooray-lb.sirv.com/fee/carousel/' . $hashed_image;
            }

            $carousel->product_id = $product->id;
            $carousel->title_en = $product->name;
            $carousel->title_ar = $product->name_ar;

            $carousel->save();

            return redirect()->back()->with('message', 'Carousel Item Updated');

        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete_carousel($id)
    {
        try
        {
            $carousel = Carousel::find($id);

            $carousel->delete();

            return redirect()->back()->with('message', 'Carousel Item Deleted');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
