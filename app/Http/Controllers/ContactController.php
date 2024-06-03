<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Organisation;
use Illuminate\Http\Request;
use App\Services\DataFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Requests\StoreOrganisationRequest;
use App\Http\Requests\UpdateOrganisationRequest;

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
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $contactRequest, StoreOrganisationRequest $organisationRequest)
    {
        try {
            $validatedContactData = $contactRequest->validated();
            $validatedOrganisationData = $organisationRequest->validated();

            DB::beginTransaction();
            $formattedContactData = DataFormatter::formatContact($validatedContactData);
            $formattedOrganisationData = DataFormatter::formatOrganisation($validatedOrganisationData);

            $organisation = Organisation::create($formattedOrganisationData);
            $formattedContactData['organisation_id'] = $organisation->id;

            Contact::create($formattedContactData);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Contact et organisation ajoutés avec succès.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        try {
            $contactWithOrganization = Contact::with('organisation')->findOrFail($contact->id);
            return response()->json($contactWithOrganization);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Contact non trouvé.'], 404);
        }
    }  

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $contactRequest, UpdateOrganisationRequest $organisationRequest, $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $organisation = Organisation::findOrFail($contact->organisation_id);
    
            $validatedContactData = $contactRequest->validated();
            $validatedOrganisationData = $organisationRequest->validated();
            
            $formattedContactData = DataFormatter::formatContactForUpdate($validatedContactData);
            $formattedOrganisationData = DataFormatter::formatOrganisationForUpdate($validatedOrganisationData);

            DB::beginTransaction();
            $organisation->update($formattedOrganisationData);
            $contact->update($formattedContactData);
            DB::commit();
    
            return redirect()->route('contacts.index')->with('success', 'Contact et organisation mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('contacts.index')->with('error', 'Une erreur est survenue lors de la mise à jour du contact.');
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        try {
            DB::beginTransaction();
            $contact->delete();
            if ($contact->organisation->contacts()->count() === 0) {
                $contact->organisation->delete();
            }
            DB::commit();

            return redirect()->route('contacts.index')->with('success', 'Contact supprimé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('contacts.index')->with('error', 'Une erreur est survenue lors de la suppression du contact.');
        }
    }
    
    /**
     * Recherche des contacts par nom, prénom ou nom d'organisation.
     */
    public function search(Request $request)
    {
        $query = $request->input('search');
        
        if (empty($query)) {
            return redirect('contacts');
        }

        $contacts = Contact::with('organisation')
            ->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('nom', 'LIKE', "%$query%")
                            ->orWhere('prenom', 'LIKE', "%$query%");
            })
            ->orWhereHas('organisation', function ($organisationQueryBuilder) use ($query) {
                $organisationQueryBuilder->where('nom', 'LIKE', "%$query%");
            })
            ->paginate(10);

        if ($contacts->isEmpty()) {
            return redirect('contacts');
        }

        return view('contact_search', compact('contacts'));
    }

    /**
     * Check if contact or company exists.
     */
    public function check(Request $request)
    {
        $contactExists = Contact::where('prenom', $request->input('prenom'))
                                ->where('nom', $request->input('nom'))
                                ->exists();

        $companyExists = Organisation::where('nom', $request->input('entreprise'))
                                     ->exists();

        return response()->json([
            'contact_exists' => $contactExists,
            'company_exists' => $companyExists,
        ]);
    }
}
