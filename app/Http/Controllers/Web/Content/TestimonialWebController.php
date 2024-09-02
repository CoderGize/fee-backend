<?php

namespace App\Http\Controllers\Web\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\Testimonial;
use App\Models\DesignStory;
use App\Models\Show;

class TestimonialWebController extends Controller
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

    public function show_testimonial()
    {
        $testimonial = Testimonial::latest()->paginate(10);

        $show = Show::find(1);

        return view('admin.web.testimonial.show_testimonial', compact(
            'testimonial',
            'show'
        ));
    }

    public function add_testimonial(Request $request)
    {
        try
        {
            $testimonial = new Testimonial;

            $image = $request->file('img');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/testimonial/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $testimonial->img = 'https://hooray-lb.sirv.com/fee/testimonial/' . $hashed_image;
            }

            $testimonial->star = $request->star;
            $testimonial->name_en = $request->name_en;
            $testimonial->name_ar = $request->name_ar;
            $testimonial->message_en = $request->message_en;
            $testimonial->message_ar = $request->message_ar;

            $testimonial->save();

            return redirect()->back()->with('message', 'Testimonial Added');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update_testimonial(Request $request, $id)
    {
        try
        {
            $testimonial = Testimonial::find($id);

            $image = $request->file('img');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/testimonial/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $testimonial->img = 'https://hooray-lb.sirv.com/fee/testimonial/' . $hashed_image;
            }

            $testimonial->star = $request->star;
            $testimonial->name_en = $request->name_en;
            $testimonial->name_ar = $request->name_ar;
            $testimonial->message_en = $request->message_en;
            $testimonial->message_ar = $request->message_ar;

            $testimonial->save();

            return redirect()->back()->with('message', 'Testimonial Updated');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete_testimonial($id)
    {
        try
        {
            $testimonial = Testimonial::find($id);

            $testimonial->delete();

            return redirect()->back()->with('message', 'Testimonial Deleted');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $r->getMessage());
        }
    }

    public function show_designer_story()
    {
        $designstory = Designstory::latest()->paginate(10);

        $show = Show::find(1);

        return view('admin.web.designstory.show_designstory', compact(
            'designstory',
            'show'
        ));
    }

    public function add_designer_story(Request $request)
    {
        try
        {
            $designstory = new Designstory;

            $image = $request->file('img');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/designstory/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $designstory->img = 'https://hooray-lb.sirv.com/fee/designstory/' . $hashed_image;
            }

            $designstory->star = $request->star;
            $designstory->name_en = $request->name_en;
            $designstory->name_ar = $request->name_ar;
            $designstory->message_en = $request->message_en;
            $designstory->message_ar = $request->message_ar;

            $designstory->save();

            return redirect()->back()->with('message', 'Designer Story Added');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update_designer_story(Request $request, $id)
    {
        try
        {
            $designstory = Designstory::find($id);

            $image = $request->file('img');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/designstory/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $designstory->img = 'https://hooray-lb.sirv.com/fee/designstory/' . $hashed_image;
            }

            $designstory->star = $request->star;
            $designstory->name_en = $request->name_en;
            $designstory->name_ar = $request->name_ar;
            $designstory->message_en = $request->message_en;
            $designstory->message_ar = $request->message_ar;

            $designstory->save();

            return redirect()->back()->with('message', 'Designer Story Updated');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete_designer_story($id)
    {
        try
        {
            $designstory = Designstory::find($id);

            $designstory->delete();

            return redirect()->back()->with('message', 'Designer Story Deleted');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $r->getMessage());
        }
    }
}
