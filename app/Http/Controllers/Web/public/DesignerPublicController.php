<?php

namespace App\Http\Controllers\Web\public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class DesignerPublicController extends Controller
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

    public function verify($hashed_id)
    {
        $id = Crypt::decryptString($hashed_id);

        $designer = Designer::find($id);

        return view('home.designer.designer', compact('designer', 'hashed_id'));
    }

    public function submit(Request $request, $hashed_id)
    {
        try
        {
            $id = Crypt::decryptString($hashed_id);

            $designer = Designer::find($id);

            $designer->password = Hash::make($request->password);
            $designer->plain_password = $request->password;

            $image = $request->file('img');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/designer/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $designer->image = 'https://hooray-lb.sirv.com/fee/designer/' . $hashed_image;
            }

            $designer->save();

            return redirect()->route('done');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function done()
    {
        return view('home.designer.done');
    }
}
