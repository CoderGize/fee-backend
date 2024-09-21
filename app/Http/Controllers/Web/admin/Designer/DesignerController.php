<?php

namespace App\Http\Controllers\Web\admin\Designer;

use App\Http\Controllers\Controller;
use App\Models\Designer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Mail\DesignerMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class DesignerController extends Controller
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

    public function index(Request $request)
    {

        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);


        $query = Designer::query();


        if ($search) {
            $query->where('f_name', 'like', '%' . $search . '%')
                ->orWhere('l_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%');
        }


        $designers = $query->paginate($perPage);

        return view('admin.designer.index', compact('designers'));
    }

    public function create()
    {
        return view('admin.designer.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:designers',
            'username' => 'required|string|max:255|unique:designers',
        ]);

        try {
            $designer = new Designer();
            $designer->f_name = $validatedData['f_name'];
            $designer->l_name = $validatedData['l_name'];
            $designer->email = $validatedData['email'];
            $designer->password = 'fee@designer';
            $designer->plain_password = 'fee@designer';
            $designer->username = $validatedData['username'];

            $designer->save();

            $hashed_id = Crypt::encryptString($designer->id);

            $designerData = [
                'Fname' => $validatedData['f_name'],
                'Link' => env('APP_LINK') . '/designer-registration/' . $hashed_id,
            ];

            Mail::to($validatedData['email'])->send(new DesignerMessage($designerData));

            return redirect()->route('admin.designer.index')->with('message', 'Designer created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function copy($id)
    {
        try {
            $designer = Designer::findOrFail($id);

            $newDesigner = $designer->replicate();
            $newDesigner->username = $designer->username . '_copy';
            $newDesigner->email = 'copy_' . $designer->email;
            $newDesigner->password = Hash::make('defaultpassword');

            $newDesigner->save();

            return redirect()->route('admin.designer.index')->with('message', 'Designer copied successfully. Please update the username and email.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to copy designer. Please try again.');
        }
    }

    public function delete($id)
    {
        try
        {
            $designer = Designer::find($id);

            $designer->delete();

            return redirect()->back()->with('message', 'Designer Deleted');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
