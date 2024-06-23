<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreRequest;
use App\Http\Requests\Contact\UpdateRequest;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $listContact = Contact::where('user_id', Auth::user()->id)->get();
            return Inertia::render('Contact/Index', ['listContact' => $listContact]);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return Inertia::render('Contact/Create');
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $data = $request->except('avatar');

            if($request->hasFile('avatar')){
                $file = $request->file('avatar');
                $routeName = $file->store('avatars', ['disk' => 'public']);
                $data['avatar'] = $routeName;
            }

            $data['user_id'] = Auth::user()->id;
            Contact::create($data);

            /* $contact = new Contact();
            $contact->name      = $request->name;
            $contact->phone     = $request->phone;
            $contact->avatar    = $routeName;
            $contact->privacity = $request->privacity;
            $contact->user_id   = Auth::user()->id;
            $contact->save(); */

            return to_route('contact.index');
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        try {
            return Inertia::render('Contact/Edit', ['contact' => $contact]);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Contact $contact)
    {
        try {
            $data = $request->except('avatar');

            if($request->hasFile('avatar')){
                $file = $request->file('avatar');
                $routeName = $file->store('avatars', ['disk' => 'public']);
                $data['avatar'] = $routeName;

                if($contact->avatar){
                    Storage::disk('public')->delete($contact->avatar);
                }
            }

            $contact->update($data);

            return to_route('contact.edit', $contact->id);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        try {
            if($contact->avatar){
                Storage::disk('public')->delete($contact->avatar);
            }

            $contact->delete();
            return to_route('contact.index');
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}
