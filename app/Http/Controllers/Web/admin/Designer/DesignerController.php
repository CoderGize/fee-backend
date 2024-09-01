<?php

namespace App\Http\Controllers\Web\admin\Designer;

use App\Http\Controllers\Controller;
use App\Models\Designer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DesignerController extends Controller
{
    public function index()
    {
        $designers = Designer::paginate(10);
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
            'password' => 'required|string|min:8|confirmed',
            'username' => 'required|string|max:255|unique:designers',
            'image' => 'nullable|image|max:2048',
        ]);

        try {
            $designer = new Designer();
            $designer->f_name = $validatedData['f_name'];
            $designer->l_name = $validatedData['l_name'];
            $designer->email = $validatedData['email'];
            $designer->password = Hash::make($validatedData['password']);
            $designer->plain_password = $validatedData['password'];
            $designer->username = $validatedData['username'];

            if ($request->hasFile('image')) {
                $designer->image = $request->file('image')->store('designers', 'public');
            }

            $designer->save();

            return redirect()->route('admin.designer.index')->with('success', 'Designer created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create designer. Please try again.');
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

            return redirect()->route('admin.designer.index')->with('success', 'Designer copied successfully. Please update the username and email.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to copy designer. Please try again.');
        }
    }

}
