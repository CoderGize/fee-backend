<?php

namespace App\Http\Controllers\Web\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Newsletter;
use App\Exports\NewsletterExport;
use Maatwebsite\Excel\Facades\Excel;

class NewsLetterWebController extends Controller
{
    public function show_newsletter()
    {
        $subscriber = Newsletter::latest()->paginate(20);

        return view('admin.web.subscriber.show_subscriber', compact('subscriber'));
    }

    public function add_newsletter(Request $request)
    {
        try
        {
            $newsletter = new Newsletter;

            $newsletter->email = $request->email;

            $check_email = Newsletter::where('email', '=', $request->email)->first();

            if ($check_email)
            {
                $response = [
                    'status' => 401,
                    'message' => 'This email is already Subscribed',
                ];

                return response()->json($response);
            }
            else
            {
                $newsletter->save();

                $response = [
                    'status' => 200,
                    'message' => 'Successfully Subscribed',
                ];

                return response()->json($response);
            }
        }
        catch  (\Exception $e)
        {
            $response = [
                'status' => 401,
                'message' => $e->getMessage(),
            ];

            return response()->json($response);
        }
    }

    public function delete_newsletter($id)
    {
        try
        {
            $newsletter = Newsletter::find($id);

            $newsletter->delete();

            return redirect()->back()->with('message', 'Email Deleted');
        }
        catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $date = $request->input('month');

        list($year, $month) = explode('-', $date);

        return Excel::download(new NewsletterExport($month, $year), 'newsletter.xlsx');
    }
}
