<?php

namespace App\Http\Controllers\Web\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\Showroom;
use App\Models\Show;

class ShowroomWebController extends Controller
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

    public function show_showroom()
    {
        $showroom = Showroom::latest()->get();

        $showroom_count = Showroom::count();

        $show = Show::find(1);

        return view('admin.web.showroom.show_showroom', compact(
            'showroom',
            'showroom_count',
            'show'
        ));
    }

    public function add_showroom(Request $request)
    {
        try
        {
            $showroom = new Showroom;

            $image = $request->file('img');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/showroom/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $showroom->img = 'https://hooray-lb.sirv.com/fee/showroom/' . $hashed_image;
            }

            $showroom->title_en = $request->title_en;
            $showroom->title_ar = $request->title_ar;

            $showroom->save();

            return redirect()->back()->with('message', 'Showroom Item Added');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete_showroom($id)
    {
        try
        {
            $showroom = Showroom::find($id);

            $showroom->delete();

            return redirect()->back()->with('message', 'Showroom Item Deleted');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
