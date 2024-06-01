<?php

namespace App\Services;

class DataFormatter
{
    public static function formatContact(array $data)
    {
        return [
            'prenom' => ucwords(strtolower($data['prenom'])),
            'nom' => ucwords(strtolower($data['nom'])),
            'e_mail' => strtolower($data['e_mail']),
            'cle' => uniqid(),
            'telephone_fixe' => '05000000',
            'service' => 'service_x',
            'fonction' => 'fonction_x',
        ];
    }

    public static function formatContactForUpdate(array $data)
    {
        return [
            'prenom' => ucwords(strtolower($data['prenom'])),
            'nom' => ucwords(strtolower($data['nom'])),
            'e_mail' => strtolower($data['e_mail']),
        ];
    }

    public static function formatOrganisation(array $data)
    {
        return [
            'nom' => ucwords(strtolower($data['entreprise'])),
            'ville' => $data['ville'],
            'adresse' => $data['adresse'],
            'code_postal' => $data['code_postal'],
            'statut' => strtoupper($data['statut']),
            'cle' => uniqid(),
        ];
    }

    public static function formatOrganisationForUpdate(array $data)
    {
        return [
            'nom' => ucwords(strtolower($data['entreprise'])),
            'ville' => $data['ville'],
            'adresse' => $data['adresse'],
            'code_postal' => $data['code_postal'],
            'statut' => strtoupper($data['statut']),
        ];
    }
}
