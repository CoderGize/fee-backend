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
        $designers = Designer::all();
        return view('admin.designer.index', compact('designers'));
    }

    public function create()
    {
        return view('admin.designer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:designers',
            'password' => 'required|string|min:8|confirmed',
            'username' => 'required|string|max:255|unique:designers',
            'image' => 'nullable|image|max:2048',
        ]);

        $designer = new Designer();
        $designer->f_name = $request->f_name;
        $designer->l_name = $request->l_name;
        $designer->email = $request->email;
        $designer->password = Hash::make($request->password);
        $designer->username = $request->username;

        if ($request->hasFile('image')) {
            $designer->image = $request->file('image')->store('designers', 'public');
        }

        $designer->save();

        return redirect()->route('admin.designer.index')->with('success', 'Designer created successfully.');
    }
}
