<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonModel extends Model {
  protected $table = 'personnes';
  protected $primaryKey = 'id_personne';
  protected $allowedFields = [
    'id_personne',
    'nom',
    'prenoms',
    'date_naissance',
    'lieu_naissance',
    'addresse',
    'CIN',
    'mail',
    'telephone',
    'genre',
    'nationalite',
    'id_statut'
  ];
  public function exist($n, $p) {
    $c = ['nom' => $n, 'prenoms' => $p];
    $count = $this->where($c)->countAllResults();
    return $count > 0;
  }
}

