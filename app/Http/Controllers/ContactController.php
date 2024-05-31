<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Requests\StoreOrganisationRequest;
use App\Services\DataFormatter;

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
    public function store(StoreContactRequest $contactRequest, StoreOrganisationRequest $organisationRequest)
    {
        // Validation des données
        $validatedContactData = $contactRequest->validated();
        $validatedOrganisationData = $organisationRequest->validated();
        
        // Formatage des données
        $formattedContactData = DataFormatter::formatContact($validatedContactData);
        $formattedOrganisationData = DataFormatter::formatOrganisation($validatedOrganisationData);
        
        // Générer une clé unique pour l'organisation
        $formattedOrganisationData['cle'] = uniqid();
        
        // Création de l'organisation
        $organisation = Organisation::create($formattedOrganisationData);

        // Ajout de l'id de l'organisation au tableau de données du contact
        $formattedContactData['organisation_id'] = $organisation->id;

        // Générer une clé unique pour le contact
        $formattedContactData['cle'] = uniqid();
        $formattedContactData['telephone_fixe'] = 05000000;
        $formattedContactData['service'] = "service_x";
        $formattedContactData['fonction'] = "fonction_x";
        
        // Création du contact
        $contact = Contact::create($formattedContactData);

        return redirect()->route('contacts.index')->with('success', 'Contact et organisation ajoutés avec succès.');
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
    
    /**
     * Recherche des contacts par nom, prénom ou nom d'organisation.
     */
    public function search(Request $request)
    {
        $query = $request->search;
        
        if (empty($query)) {
            return redirect('contacts');
        } else {
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
    }

}
