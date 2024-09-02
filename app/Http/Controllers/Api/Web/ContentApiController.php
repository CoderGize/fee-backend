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

class ContentApiController extends Controller
{
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

    public function getBlog()
    {
        $blog = Blog::latest()->get();

        return response()->json($blog);
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
        $landing = Landing::find(1);

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
}
