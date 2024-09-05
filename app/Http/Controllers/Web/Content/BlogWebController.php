<?php

namespace App\Http\Controllers\Web\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\Blog;
use App\Models\Show;
use Carbon\Carbon;

class BlogWebController extends Controller
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

    public function show_blog()
    {
        $show = Show::find(1);

        $blog = Blog::latest()->paginate(15);

        return view('admin.web.blog.show_blog', compact('blog', 'show'));
    }

    public function add_blog(Request $request)
    {
        try
        {
            $blog = new Blog;

            $image = $request->file('img');
            $profile = $request->file('profile');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/blog/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $blog->img = 'https://hooray-lb.sirv.com/fee/blog/' . $hashed_image;
            }

            if ($profile)
            {
                $hashed_image = Str::random(20) . '.' . $profile->getClientOriginalExtension();
                $filename = '/fee/blog/' . $hashed_image;
                $profileContent = file_get_contents($profile->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $profileContent,
                ]);

                $blog->profile = 'https://hooray-lb.sirv.com/fee/blog/' . $hashed_image;
            }

            $blog->link = $request->link;
            $blog->name_en = $request->name_en;
            $blog->name_ar = $request->name_ar;
            $blog->title_en = $request->title_en;
            $blog->title_ar = $request->title_ar;
            $blog->date = Carbon::parse($request->date)->format('F j, Y');

            $blog->save();

            return redirect()->back()->with('message', 'Blog Added');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update_blog($id)
    {
        try
        {
            $blog = Blog::find($id);

            return view('admin.web.blog.update_blog', compact('blog'));
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update_blog_confirm(Request $request, $id)
    {
        try
        {
            $blog = Blog::find($id);

            $image = $request->file('img');
            $profile = $request->file('profile');

            if ($image)
            {
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/blog/' . $hashed_image;
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                $blog->img = 'https://hooray-lb.sirv.com/fee/blog/' . $hashed_image;
            }

            if ($profile)
            {
                $hashed_image = Str::random(20) . '.' . $profile->getClientOriginalExtension();
                $filename = '/fee/blog/' . $hashed_image;
                $profileContent = file_get_contents($profile->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $profileContent,
                ]);

                $blog->profile = 'https://hooray-lb.sirv.com/fee/blog/' . $hashed_image;
            }

            $blog->link = $request->link;
            $blog->name_en = $request->name_en;
            $blog->name_ar = $request->name_ar;
            $blog->title_en = $request->title_en;
            $blog->title_ar = $request->title_ar;
            $blog->date = Carbon::parse($request->date)->format('F j, Y');

            $blog->save();

            return redirect('/admin/web/show_blog')->with('message', 'Blog Updated');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete_blog($id)
    {
        try
        {
            $blog = Blog::find($id);

            $blog->delete();

            return redirect()->back()->with('message', 'Blog Deleted');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
