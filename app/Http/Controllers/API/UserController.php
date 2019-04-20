<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return User::latest()->paginate();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($request->photo !== '') {
            // prepare image name
            $name = time().'.'.explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            // send image to the server
            \Image::make($request->photo)->save(public_path('img/profile/').$name);

            $request->merge(['photo' => $name]);
        }

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            'photo' => $request['photo'],
            'password' => Hash::make($request['password'])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Return the profile information
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function profile()
    {
       return auth('api')->user();
    }

    /**
     * Update Profile Information
     *
     * @param Request $request
     *
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateProfile(Request $request)
    {
       $user = auth('api')->user();

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|min:8'
        ]);

       $currentPhoto = $user->photo;

       if($request->photo != $currentPhoto) {

           // prepare image name
           $name = time().'.'.explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

           // send image to the server
           \Image::make($request->photo)->save(public_path('img/profile/').$name);

           $userPhoto = public_path('img/profile/').$name;

           // delete old picture from server
           if(file_exists($userPhoto) && $currentPhoto !== 'profile.png') {
               @unlink($currentPhoto);
           }

           $request->merge(['photo' => $name]);
       }

       if(!empty($request->password)) {
           $request->merge(['password' => Hash::make($request->password)]);
       }

       // update the user/profile
       $user->update($request->all());

       return ['message' => 'Profile Updated'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Reques $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:8'
        ]);

        $currentPhoto = $user->photo;

        if($request->photo != $currentPhoto) {

            // prepare image name
            $name = time().'.'.explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            // send image to the server
            \Image::make($request->photo)->save(public_path('img/profile/').$name);

            $userPhoto = public_path('img/profile/').$name;

            // delete old picture from server
            if(file_exists($userPhoto) && $currentPhoto !== 'profile.png') {
                @unlink($currentPhoto);
            }

            $request->merge(['photo' => $name]);
        }

        // update the user
        $user->update($request->all());

        return ['message' => 'User Updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $user = User::findOrFail($id);

        // delete the photo from server
        $userPhoto = public_path('img/profile/').$user->photo;
        if(file_exists($userPhoto) && $user->photo !== 'profile.png') {
            @unlink($userPhoto);
        }

        // delete the user
        $user->delete();

        // redirect
        return['message' => 'User Deleted'];
    }

    /**
     * Search for specific user by name, email or type
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $users = '';

        if ($search = \Request::get('q')) {
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                      ->orWhere('email','LIKE',"%$search%")
                      ->orWhere('type','LIKE',"%$search%");
            })->paginate(3);
        } else {
            $users = User::latest()->paginate(3);
        }

        return $users;
    }
}
