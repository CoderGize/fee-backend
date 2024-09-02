<?php

namespace App\Http\Controllers\Web\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\About;

class AboutWebController extends Controller
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

    public function show_about()
    {
        $about = About::find(1);

        return view('admin.web.about.show_about', compact('about'));
    }

    public function update_about(Request $request)
    {
        try
        {
            $about = About::find(1);

            $image = $request->file('img');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/about/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $about->img = 'https://hooray-lb.sirv.com/fee/about/' . $hashed_image;
            }

            $about->about_en = $request->about_en;
            $about->about_ar = $request->about_ar;
            $about->vision_en = $request->vision_en;
            $about->vision_ar = $request->vision_ar;
            $about->mission_en = $request->mission_en;
            $about->mission_ar = $request->mission_ar;
            $about->whyus_title_en = $request->whyus_title_en;
            $about->whyus_title_ar = $request->whyus_title_ar;
            $about->whyus_text_en = $request->whyus_text_en;
            $about->whyus_text_ar = $request->whyus_text_ar;

            $about->save();

            return redirect()->back()->with('message', 'About Content Updated');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
