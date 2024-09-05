<?php

namespace App\Http\Controllers\Web\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Show;

class ShowWebController extends Controller
{
    public function blog_show(Request $request)
    {
        try
        {
            $show = Show::find(1);

            if ($show->blog_sh == 1)
            {
                $show->blog_sh = 0;

                $show->save();

                return redirect()->back()->with('message', 'Blog is hidden');
            }
            elseif ($show->blog_sh == 0)
            {
                $show->blog_sh = 1;

                $show->save();

                return redirect()->back()->with('message', 'Blog is Visible');
            }
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function showroom_show(Request $request)
    {
        try
        {
            $show = Show::find(1);

            if ($show->showroom_sh == 1)
            {
                $show->showroom_sh = 0;

                $show->save();

                return redirect()->back()->with('message', 'Showroom is hidden');
            }
            elseif ($show->showroom_sh == 0)
            {
                $show->showroom_sh = 1;

                $show->save();

                return redirect()->back()->with('message', 'Showroom is Visible');
            }
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function testimonial_show(Request $request)
    {
        try
        {
            $show = Show::find(1);

            if ($show->testimonial_sh == 1)
            {
                $show->testimonial_sh = 0;

                $show->save();

                return redirect()->back()->with('message', 'Testimonial is hidden');
            }
            elseif ($show->testimonial_sh == 0)
            {
                $show->testimonial_sh = 1;

                $show->save();

                return redirect()->back()->with('message', 'Testimonial is Visible');
            }
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function designer_destimonial_show(Request $request)
    {
        try
        {
            $show = Show::find(1);

            if ($show->designer_destimonial_sh == 1)
            {
                $show->designer_destimonial_sh = 0;

                $show->save();

                return redirect()->back()->with('message', 'Designer Story is hidden');
            }
            elseif ($show->designer_destimonial_sh == 0)
            {
                $show->designer_destimonial_sh = 1;

                $show->save();

                return redirect()->back()->with('message', 'Designer Story is Visible');
            }
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function carousel_show(Request $request)
    {
        try
        {
            $show = Show::find(1);

            if ($show->carousel_sh == 1)
            {
                $show->carousel_sh = 0;

                $show->save();

                return redirect()->back()->with('message', 'Carousel is hidden');
            }
            elseif ($show->carousel_sh == 0)
            {
                $show->carousel_sh = 1;

                $show->save();

                return redirect()->back()->with('message', 'Carousel is Visible');
            }
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
