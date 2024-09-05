<?php

namespace App\Http\Controllers\Web\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designletter;
use App\Exports\DesignletterExport;
use Maatwebsite\Excel\Facades\Excel;

class DesignLetterWebController extends Controller
{
    public function show_designletter()
    {
        $designletter = DesignLetter::latest()->paginate(20);

        return view('admin.web.subscriber.show_designletter', compact('designletter'));
    }

    public function add_designletter(Request $request)
    {
        try
        {
            $designletter = new Designletter;

            $designletter->email = $request->email;

            $check_email = Designletter::where('email', '=', $request->email)->first();

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
                $designletter->save();

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

    public function delete_designletter($id)
    {
        try
        {
            $designletter = Designletter::find($id);

            $designletter->delete();

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

        return Excel::download(new DesignletterExport($month, $year), 'Designer-letter.xlsx');
    }
}
