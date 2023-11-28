<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminController extends Controller
{
    public function list() {

        $data['getRecord'] = User::getAdmin();
        $data['header_title'] = "List";

        return view('admin.admin.list', $data);
    }

    public function add() {
        $data['header_title'] = "Add New Admin";

        return view('admin.admin.add', $data);
    }

    public function insert(Request $request) {

        request()->validate([
            // 'firstName'=> 'required',
            // 'lastName'=> 'required',
            'email'=> 'required|email|unique:users'
            // 'password'=> 'required',
            // 'password'=> 'required'
        ]);

        // $admin = new Admin;
        // $admin->firstName = trim($request->fname);
        // $admin->lastName = trim($request->lname);
        // $admin->email = $request->email;
        // $admin->contactNumber = $request->contactNumber;
        // $admin->password = Hash::make($request->password);
        // $admin->save();

        $user = new User;
        $user->name = Str::ucfirst(trim($request->name));
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_type = 1;
        $user->save();

        return redirect('admin/admin/list')->with('success', "Admin successfully added!");

    }

    public function edit($id) {

        $data['getRecord'] = User::getSingle($id);

        if(!empty($data['getRecord'])){
            $data['header_title'] = "Edit Admin";
            return view('admin.admin.edit', $data);
        }else{
            abort(404);
        }
    }

    public function update($id, Request $request) {

        request()->validate([
            // 'firstName'=> 'required',
            // 'lastName'=> 'required',
            'email'=> 'required|email|unique:users,email,'.$id
        ]);

        $user = User::getSingle($id);
        $user->name = trim($request->name);
        $user->email = $request->email;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('admin/admin/list')->with('success', "Admin successfully updated!");
    }

    public function delete($id) {

        $user = User::getSingle($id);

        if(!empty($user)){
            $user->is_deleted = 1;
            $user->save();

            return redirect('admin/admin/list')->with('success', "Admin successfully deleted!");
        }else{
            abort(404);
        }
    }

}
