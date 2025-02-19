<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('user-management.users.index', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required'],
        ]);

        $user->syncRoles($request->role);
        toast('Successfully added!', 'success');
        return back();
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required | string | max:255',
            'email' => 'required | string | email | max:255 | unique:users',
            'password' => 'required | min:8 ',
        ]);

        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'password_reset' => $request->password_reset == 1,
        ]);

        Alert::success('Success!', 'Successfully added');
        return back();
    }
    public function destroy($id)
    {
        $role = User::findOrFail($id);
        $role->delete();
        Alert::success('Success!', 'Successfully deleted');
        return back();
    }
    public function edit($id)
    {
      
        $user = User::findOrFail($id);

        return view('user-management.users.editUser', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required | string | max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'password' => 'required | min:8 ',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        $validated = $validator->safe()->only(['name', 'email', 'password']);
        $validated['password'] = Hash::make($validated['password']);
        User::whereId($id)->update($validated);
        Alert::success('Success!', 'Successfully Updated');
        return redirect()->route('users.index');
    }
    
    
public function changePassword(Request $request)
{
    // Validate the password change request
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8',
        'confirm_password' => 'required|same:new_password',
    ]);

    // Code to update the user's password
    $id = Auth::user()->id;

    $user = User::findOrFail($id);

    // Check if the new password is the same as the old password
    if (Hash::check($request->input('new_password'), $user->password)) {
        Alert::error('Error!', 'New password cannot be the same as the old password.');
        return back();
    }

    // Update the password
    $user->password = Hash::make($request->input('new_password'));
    $user->save();

    Alert::success('Success!', 'Password changed successfully.');
    return back();
}


public function editUserPassword(Request $request)
{
    // Validate the password change request
    $request->validate([
         'new_password' => 'required|min:8',
        'confirm_password' => 'required|same:new_password',
    ]);

    // Code to update the user's password
    $id = request('user_id');

    $user = User::findOrFail($id);

    // Check if the new password is the same as the old password
    if (Hash::check($request->input('new_password'), $user->password)) {
        Alert::error('Error!', 'New password cannot be the same as the old password.');
        return back();
    }

    // Update the password
    $user->password = Hash::make($request->input('new_password'));
    $user->save();

    Alert::success('Success!', 'Password changed successfully.');
    return back();
}

// public function updateProfile(Request $request)
// {
//     // Validate the password change request
//     $request->validate([
//         'profile_picture' => 'required',
//     ]);


//     $id = Auth::user()->id;

//     $user = User::findOrFail($id);
    
//     $path = Storage::putFile('profile_picture', $request->file('profile_picture'));
//     $user->profile_picture = $path;
//     $user->save();

//     Alert::success('Success!', 'Profile Picture uploaded successfully.');
//     return back();
// }

public function updateProfile(Request $request)
{
    // Validate the profile picture upload
    $request->validate([
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules as needed
    ]);

    $id = Auth::user()->id;
    $user = User::findOrFail($id);

    if ($request->hasFile('profile_picture')) {
$image = $request->file('profile_picture');
$imagePath = 'profile_picture/'. $image->getClientOriginalName();
$image->move(public_path('assets/profile_picture'), $image->getClientOriginalName());        // Store the image path in the user's profile_picture field
        $user->profile_picture = $imagePath;
        $user->save();

        Alert::success('Success!', 'Profile Picture uploaded successfully.');
    } else {
        Alert::error('Error!', 'Profile Picture upload failed.');
    }

    return back();
}




}
