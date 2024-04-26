<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonModel extends Model {
  protected $table = 'personnes';
  protected $allowedFields = [];
  public function exist($n, $p) {
    $c = ['nom' => $n, 'prenoms' => $p];
    $count = $this->where($c)->countAllResults();
    if($count > 0) return true;
    return false;
  }
}

