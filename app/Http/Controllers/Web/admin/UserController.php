<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);


        $query = User::where('is_admin', false);


        if ($search) {
            $query->where('f_name', 'like', '%' . $search . '%')
                ->orWhere('l_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%');
        }


        $designers = $query->paginate($perPage);


        return view('admin.user.index', compact('designers'));
    }

    public function delete($id)
    {

        $designer = User::where('id', $id)->where('is_admin', false)->first();


        if ($designer) {
            $designer->delete();
            return redirect()->back()->with('message', 'Designer deleted successfully.');
        }

        return redirect()->back()->with('error', 'Designer not found or is an admin.');
    }
}
