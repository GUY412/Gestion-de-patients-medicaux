<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'nom', 'prenom', 'telephone', 'numero_cmu',
        'a_assurance', 'numero_assurance', 'date_naissance', 'sexe', 'adresse'
    ];

    public function antecedents()
    {
        return $this->hasMany(Antecedent::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}