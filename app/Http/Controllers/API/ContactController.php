<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;


class ContactController extends Controller
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
        if (\Gate::allows('isLogged') || \Gate::allows('isAdmin') || \Gate::allows('isUser') || \Gate::allows('isAuthor')) {
            return Contact::latest()->paginate(3);
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
            'email' => 'required|string|email|max:191|unique:contacts',
        ]);

        if($request['photo'] != '') {

            // prepare image name
            $name = time().'.'.explode('/', explode(':', substr($request['photo'], 0, strpos($request['photo'], ';')))[1])[1];

            // send image to the server
            \Image::make($request['photo'])->save(public_path('img/contact/').$name);

            $request->merge(['photo' => $name]);
        }

        return Contact::create([
            'name' => $request['name'],
            'photo' => $request['photo'],
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'mobile' => $request['mobile'],
            'fax' => $request['fax'],
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
     * Update the specified resource in storage.
     *
     * @param Illuminate\Http\Reques $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:contacts,email,'.$contact->id,
            'address' => '',
            'phone' => '',
            'mobile' => '',
            'fax' => '',
            'photo' => ''
        ]);

        $currentPhoto = $contact->photo;

        if($request['photo'] != $currentPhoto) {

            // prepare image name
            $name = time().'.'.explode('/', explode(':', substr($request['photo'], 0, strpos($request['photo'], ';')))[1])[1];

            // send image to the server
            \Image::make($request['photo'])->save(public_path('img/contact/').$name);

            $contactPhoto = public_path('img/contact/').$name;

            // delete old picture from server
            if(file_exists($contactPhoto) && $currentPhoto !== 'profile.png') {
                @unlink($currentPhoto);
            }

            $request->merge(['photo' => $name]);
        }

        // update the user
        $contact->update($request->all());

        return ['message' => 'Contact Updated'];
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

        $contact = Contact::findOrFail($id);

        // delete the photo from server
        $contactPhoto = public_path('img/contact/').$contact->photo;
        if(file_exists($contactPhoto) && $contact->photo !== 'profile.png') {
            @unlink($contactPhoto);
        }

        // delete the user
        $contact->delete();

        // redirect
        return['message' => 'Contact Deleted'];
    }

    /**
     * Search for specific contact by name, email, address, phone, mobile or fax
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $contacts = '';

        if ($search = \Request::get('q')) {
            $contacts = Contact::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                      ->orWhere('email','LIKE',"%$search%")
                      ->orWhere('address','LIKE',"%$search%")
                      ->orWhere('phone','LIKE',"%$search%")
                      ->orWhere('mobile','LIKE',"%$search%")
                      ->orWhere('fax','LIKE',"%$search%");
            })->paginate(3);
        } else {
            $contacts = Contact::latest()->paginate(3);
        }

        return $contacts;
    }
}
