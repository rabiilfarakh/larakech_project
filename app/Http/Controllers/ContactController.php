<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Requests\StoreOrganisationRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::with('organisation')->paginate(10);
        return view('contact', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, StoreContactRequest $contactRequest, StoreOrganisationRequest $organisationRequest)
    {
        dd("hey");
        // $contactData = $contactRequest->validated();
        // $organisationData = $organisationRequest->validated();

        // DB::beginTransaction();

        // try {
        //     $organisation = Organisation::create($organisationData);

        //     $contactData['organisation_id'] = $organisation->id;

        //     $contact = Contact::create($contactData);

        //     DB::commit();

        //     return redirect()->route('contacts')->with('success', 'Contact et organisation ajoutés avec succès.');
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return redirect()->route('contacts')->with('error', 'Une erreur est survenue lors de la création du contact et de l\'organisation.');
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        $contactWithOrganization = Contact::with('organisation')->findOrFail($contact->id);
        return response()->json($contactWithOrganization);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        dd("update");
    }

    /**
     * Remove the specified resource from storage.
     */
/**
 * Remove the specified resource from storage.
 */
    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            if ($contact->organisation->contacts()->count() === 0) {
                $contact->organisation->delete();
            }

            return redirect()->route('contacts.index')->with('success', 'Contact supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('contacts.index')->with('error', 'Une erreur est survenue lors de la suppression du contact.');
        }
    }

}
