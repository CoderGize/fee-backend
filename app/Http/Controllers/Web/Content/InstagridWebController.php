<?php

namespace App\Http\Controllers\Web\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\Instagrid;

class InstagridWebController extends Controller
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

    public function show_instagrid()
    {
        $instagrid = Instagrid::get();

        $insta_count = Instagrid::count();

        return view('admin.web.instagrid.show_instagrid', compact('instagrid', 'insta_count'));
    }

    public function add_instagrid(Request $request)
    {
        try
        {
            $instagrid = new Instagrid;

            $image = $request->file('img');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/instagrid/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $instagrid->img = 'https://hooray-lb.sirv.com/fee/instagrid/' . $hashed_image;
            }

            $instagrid->save();

            return redirect()->back()->with('message', 'Post Added');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete_instagrid($id)
    {
        try
        {
            $instagrid = Instagrid::find($id);

            $instagrid->delete();

            return redirect()->back()->with('message', 'Post Deleted');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
