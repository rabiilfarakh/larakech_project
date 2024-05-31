<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contact';
    protected $fillable = [
        'cle',
        'organisation_id',
        'e_mail',
        'nom',
        'prenom',
        'telephone_fixe',
        'service',
        'fonction',
    ];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    // // Mutator pour le prénom
    // public function setPrenomAttribute($value)
    // {
    //     $this->attributes['prenom'] = ucwords(strtolower($value));
    // }

    // // Mutator pour le nom
    // public function setNomAttribute($value)
    // {
    //     $this->attributes['nom'] = ucwords(strtolower($value));
    // }
    // // Mutator pour l'email
    // public function setEmailAttribute($value)
    // {
    //     $this->attributes['e_mail'] = ucwords(strtolower($value));
    // }

}
