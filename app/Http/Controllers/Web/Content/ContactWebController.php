<?php

namespace App\Http\Controllers\Web\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contactweb;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class ContactWebController extends Controller
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

    public function show_contact()
    {
        $contact = Contactweb::find(1);

        return view('admin.web.contact.show_contact', compact('contact'));
    }

    public function update_contact(Request $request)
    {
        try
        {
            $contact = Contactweb::find(1);

            $image = $request->file('img');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/contact/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $contact->img = 'https://hooray-lb.sirv.com/fee/contact/' . $hashed_image;
            }

            $contact->save();

            return redirect()->back()->with('message', 'Contact Page Updated');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
