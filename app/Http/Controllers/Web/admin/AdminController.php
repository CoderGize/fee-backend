<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);


        $query = User::where('is_admin', 1);


        if ($search) {
            $query->where('f_name', 'like', '%' . $search . '%')
                ->orWhere('l_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%');
        }


        $users = $query->paginate($perPage);


        return view('admin.managers.index', compact('users'));
    }


       public function store(Request $request)
       {

           $validator = Validator::make($request->all(), [
               'f_name' => 'required|string|max:255',
               'l_name' => 'required|string|max:255',
               'email' => 'required|email|unique:users,email',
               'password' => 'required|min:6|confirmed',
               'username' => 'required|string|max:255|unique:users,username',
               'image' => 'nullable|image|mimes:jpg,jpeg,png',
               'further_information' => 'nullable|string',
               'governorate' => 'nullable|string|max:255',
               'locality' => 'nullable|string|max:255',
               'region' => 'nullable|string|max:255',
               'birth_day' => 'nullable|date',
               'is_admin' => 'boolean',
               'role' => 'required|string|max:255',
           ]);

           if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', $validator->errors())->withInput();
        }

       try{

           $imagePath = null;
           if ($request->hasFile('image')) {
               $imagePath = $request->file('image')->store('users', 'public');
           }


           $user = User::create([
               'f_name' => $request->f_name,
               'l_name' => $request->l_name,
               'email' => $request->email,
               'password' => Hash::make($request->password),
               'username' => $request->username,
               'image' => $imagePath,
               'further_information' => $request->further_information,
               'governorate' => $request->governorate,
               'locality' => $request->locality,
               'region' => $request->region,
               'birth_day' => $request->birth_day,
               'is_admin' => 1,
               'role' => $request->role,
           ]);

           return redirect()->route('admin.managers')->with('message', 'User created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
       }


       public function edit($id)
       {
           $user = User::findOrFail($id);

           return view('admin.managers.edit', compact('user'));
       }

       public function update(Request $request, $id)
       {
           $user = User::findOrFail($id);


           $validator = Validator::make($request->all(), [
               'f_name' => 'required|string|max:255',
               'l_name' => 'required|string|max:255',
               'email' => 'required|email|unique:users,email,' . $user->id,
               'username' => 'required|string|max:255|unique:users,username,' . $user->id,
               'image' => 'nullable|image|mimes:jpg,jpeg,png',
               'further_information' => 'nullable|string',
               'governorate' => 'nullable|string|max:255',
               'locality' => 'nullable|string|max:255',
               'region' => 'nullable|string|max:255',
               'birth_day' => 'nullable|date',
               'is_admin' => 'boolean',
               'role' => 'required|string|max:255',
           ]);

           if ($validator->fails()) {
               return redirect()->back()->withErrors($validator)->withInput();
           }


           if ($request->hasFile('image')) {
               $imagePath = $request->file('image')->store('users', 'public');
               $user->image = $imagePath;
           }


           $user->update([
               'f_name' => $request->f_name,
               'l_name' => $request->l_name,
               'email' => $request->email,
               'username' => $request->username,
               'further_information' => $request->further_information,
               'governorate' => $request->governorate,
               'locality' => $request->locality,
               'region' => $request->region,
               'birth_day' => $request->birth_day,
               'is_admin' => $request->is_admin,
               'role' => $request->role,
           ]);

           return redirect()->route('admin.managers')->with('message', 'User updated successfully.');
       }

       // Delete an existing user
       public function delete($id)
       {
           $user = User::findOrFail($id);
           $user->delete();

           return redirect()->route('admin.managers')->with('message', 'User deleted successfully.');
       }
}
