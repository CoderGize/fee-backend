<?php

namespace App\Http\Controllers\Web\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Landing;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class LandingWebController extends Controller
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

    public function show_landing()
    {
        $landing = Landing::find(1);

        return view('admin.web.landing.show_landing', compact(
            'landing'
        ));
    }

    public function update_landing(Request $request)
    {
        try
        {
            $landing = Landing::find(1);

            $image = $request->file('img');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/landing/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $landing->img = 'https://hooray-lb.sirv.com/fee/landing/' . $hashed_image;
            }

            $landing->save();

            return redirect()->back()->with('message', 'Landing Updated');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }
}
