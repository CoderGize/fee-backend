<?php

namespace App\Http\Controllers\Web\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Becomedesigner;
use App\Models\Becomedesignerbenefit;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class BecomeDesignerController extends Controller
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

    public function show_become_designer()
    {
        $becomedesigner = Becomedesigner::find(1);

        $becomedesignerbenefit = Becomedesignerbenefit::latest()->paginate(5);

        return view('admin.web.become-designer.show_become_designer', compact(
            'becomedesigner',
            'becomedesignerbenefit',
        ));
    }

    public function update_become_designer(Request $request)
    {
        try
        {
            $becomedesigner = Becomedesigner::find(1);

            $becomedesigner->text_en = $request->text_en;
            $becomedesigner->text_ar = $request->text_ar;

            $becomedesigner->save();

            return redirect()->back()->with('message', 'Section Updated');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function add_become_designer(Request $request)
    {
        try
        {
            $becomedesignerbenefit = new Becomedesignerbenefit;

            $becomedesignerbenefit->point_en = $request->point_en;
            $becomedesignerbenefit->point_ar = $request->point_ar;

            $becomedesignerbenefit->save();

            return redirect()->back()->with('message', 'Benefit Added');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete_become_designer($id)
    {
        try
        {
            $becomedesignerbenefit = Becomedesignerbenefit::find($id);

            $becomedesignerbenefit->delete();

            return redirect()->back()->with('message', 'Benefit Deleted');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
