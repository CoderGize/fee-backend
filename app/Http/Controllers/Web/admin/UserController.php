<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

        $designers = User::where('is_admin', false)->paginate(10);


        return view('admin.user.index', compact('designers'));
    }

    public function delete($id)
    {

        $designer = User::where('id', $id)->where('is_admin', false)->first();


        if ($designer) {
            $designer->delete();
            return redirect()->back()->with('success', 'Designer deleted successfully.');
        }

        return redirect()->back()->with('error', 'Designer not found or is an admin.');
    }
}
