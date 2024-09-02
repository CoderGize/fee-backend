<?php

namespace App\Http\Controllers\Web\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Download;

class DownloadWebController extends Controller
{
    public function show_download()
    {
        $download = Download::find(1);

        return view('admin.web.download.show_download', compact('download'));
    }

    public function update_download(Request $request)
    {
        try
        {
            $download = Download::find(1);

            $download->ios_link = $request->ios_link;
            $download->android_link = $request->android_link;

            $download->save();

            return redirect()->back()->with('message', 'App Download Links Updated');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
