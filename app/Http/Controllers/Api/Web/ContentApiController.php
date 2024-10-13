<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\Becomedesigner;
use App\Models\Becomedesignerbenefit;
use App\Models\Blog;
use App\Models\Carousel;
use App\Models\Contactweb;
use App\Models\Designstory;
use App\Models\Download;
use App\Models\Instagrid;
use App\Models\Landing;
use App\Models\Show;
use App\Models\Showroom;
use App\Models\Social;
use App\Models\Testimonial;
use App\Mail\Contactform;
use Illuminate\Support\Facades\Mail;

class ContentApiController extends Controller
{
  	public function contact_form(Request $request)
    {
      try
      {
	     $contactData = [
           'name' => $request->name,
           'email' => $request->email,
           'message' => $request->message
         ];

		Mail::to('anthony@codergize.com')->send(new Contactform($contactData));

        return response()->json([
                            'status' => 200,
                            'message' => 'Email Sent'
                        ]);
      }
      catch (\Exception $e)
      {
        return response()->json([
        'error' => $e->getMessage()
        ]);
      }
    }

    public function getAbout()
    {
        $about = About::find(1);

        return response()->json($about);
    }

    public function getBecomeDesigner()
    {
        $become = BecomeDesigner::find(1);

        return response()->json($become);
    }

    public function getBecomeDesignerBenefit()
    {
        $benefit = BecomeDesignerBenefit::latest()->get();

        return response()->json($benefit);
    }

    public function getCarousel()
    {
        $carousel = Carousel::latest()->get();

        return response()->json($carousel);
    }

    public function getBlog(Request $request)
    {
        try{
        $perPage = $request->per_page ? $request->per_page : 10;
        $blog = Blog::latest()->paginate($perPage);

        return response()->json($blog);
        }catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getBlogId($id)
    {
        try{

        $blog = Blog::find($id);

        return response()->json($blog);
        }catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getContactWeb()
    {
        $contact = ContactWeb::find(1);

        return response()->json($contact);
    }

    public function getDesignerStory()
    {
        $story = DesignStory::latest()->get();

        return response()->json($story);
    }

    public function getDownload()
    {
        $download = Download::find(1);

        return response()->json($download);
    }

    public function getInstagrid()
    {
        $insta = Instagrid::latest()->get();

        return response()->json($insta);
    }

    public function getLanding()
    {
        $landing = Landing::latest()->get();

        return response()->json($landing);
    }

    public function getShow()
    {
        $show = Show::find(1);

        return response()->json($show);
    }

    public function getShowroom()
    {
        $showroom = Showroom::latest()->get();

        return response()->json($showroom);
    }

    public function getSocial()
    {
        $social = Social::find(1);

        return response()->json($social);
    }

    public function getTestimonial()
    {
        $testimonial = Testimonial::latest()->get();

        return response()->json($testimonial);
    }

  public function getHomepage()
  {
    $landing = Landing::latest()->get();
    $carousel = Carousel::latest()->get();
    $showroom = Showroom::latest()->get();
    $testimonial = Testimonial::latest()->get();
    $blog = Blog::latest()->get();
	$insta = Instagrid::latest()->get();
	$about = About::find(1);
    $social = Social::find(1);
    $contact = ContactWeb::find(1);
	$download = Download::find(1);
	$show = Show::find(1);

    $data = [
      'response' => [
      	'landing_data' => $landing,
        'carousel_data' => $carousel,
        'showroom_data' => $showroom,
        'testimonial_data' => $testimonial,
        'blog_data' => $blog,
        'insta_grid_data' => $insta,
        'about_data' => $about,
        'social_data' => $social,
        'contact_data' => $contact,
        'download_data' => $download,
        'show_data' => $show
      ]
    ];

	return response()->json($data);
  }
}
