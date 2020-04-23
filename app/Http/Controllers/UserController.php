<?php

namespace App\Http\Controllers;

use App\Shipment;
use App\User;
use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function logged_user()
    {
        $user = new User();
        return  $user->logged_user();
    }
    public function index()
    {
        $users = Admin::orderBy('name')->with('roles')->paginate(500);
        $users->transform(function ($user, $key) {
            $user->status = ($user->active) ? 'active' : 'not active';
            $user->active_status = ($user->active) ? 'true' : null;
            $role = (!empty($user->roles[0])) ? $user->roles[0] : 0;
            // dd($role);
            $user->role = $role['id'];
            return $user;
        });
        return response()->json($users);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->Validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'phone' => 'required',
        ]);
        $admin = new Admin;
        $password = $this->generateRandomString();
        $password_hash = Hash::make($password);
        $admin->password = $password_hash;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->address = $request->address;
        $admin->active = ($request->active_status) ? true : false;
        $admin->save();
        $admin->roles()->sync(request('role'));
        // $user->assignRole($request->role_id);

        return $admin;
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $this->Validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required'
        ]);
        $admin = Admin::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->address = $request->address;
        $admin->active = ($request->active_status) ? true : false;
        $admin->save();
        $admin->roles()->sync(request('role'));

        return $admin;
    }

    public function AuthUserUp(Request $request)
    {
        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->branch_id = $request->branch_id;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::find($user->id)->delete();
    }

    public function getLogedinUsers()
    {
        return $this->logged_user();
    }

    public function profile(Request $request, $id)
    {
        $upload = User::find($request->id);
        if ($request->hasFile('image')) {
            // return('test');
            // $imagename = time() . $request->image->getClientOriginalName();
            // $request->image->storeAs('public/test', $imagename);
            $img = $request->image;
            // $image_path = ;

            if (File::exists('storage/profile/' . $upload->image)) {

                // return('test');
                $image_path = 'storage/profile/' . $upload->image;

                File::delete($image_path);
                // return $image_path;
            }
            // $imagename =  Storage::disk('uploads')->put('profile', $img);
            $imagename = Storage::disk('public')->put('profile', $img);
        }

        // return('noop');
        $imgArr = explode('/', $imagename);
        $image_name = $imgArr[1];
        $upload->profile = '/storage/profile/' . $image_name;
        // $upload->profile = '/healthwise/products/'.$image_name;
        $upload->save();
        return $upload;
    }


    public function password(Request $request)
    {
        $this->Validate($request, [
            'password' => 'required|string|min:6',
            // 'password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->password);
        $user->save();
        return $user;
    }

    public function logoutOther()
    {
        return view('auth.Logout');
    }

    public function logOtherDevices(Request $request)
    {
        Auth::logoutOtherDevices($request->password);
        return redirect('/courier');
    }

    public function permisions(Request $request, $id)
    {
        // return $request->all();
        $user = User::find($id);
        $user->syncPermissions($request->selected);
        return $user;
    }


    public function undeletedUser($id)
    {
        User::withTrashed()->find($id)->restore();
    }

    public function force_user($id)
    {
        User::withTrashed()->find($id)->forceDelete();
    }

    public function deletedUsers()
    {
        $users = User::onlyTrashed()->get();
        return $users;
    }


    public function getUserPerm(Request $request, $id)
    {
        $user = User::find($id);
        $permissions = $user->getAllPermissions();
        $can = [];
        foreach ($permissions as $perm) {
            $can[] = $perm->name;
        }
        return $can;
    }

}
