<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
  protected $table = 'utilisateurs';
  protected $builder;
  // public $db = \Config\Database::connect();
  protected $allowedFields = ['id_utilisateurs', 'id_personne', 'nom', 'prenom', 'password', 'est_actif', 'statut'];
  public function __construct() {
    // $builder = $db->table($this->table);
  }
  // ATY NO INSERTION ANATY DATABASE
  public function inscription($data) {
    return $this->insert($data);
  }
  // 
  public function connexion(string $nom, string $prenoms, string $mdp) : bool {
    $conditions = ['nom' => $nom, 'prenom' => $prenoms, 'password' => $mdp];
    $this->set(['est_actif', 1])->where($conditions)->update();
    return true;
  }
  public function verifyPassword(string $nom, string $prenom, $mdp) {
    $conditions = ['nom' => $nom, 'prenom' => $prenom];
    $users = $this->where($conditions)->get()->getResultArray();
    foreach ($users as $user) {
      if(password_verify($mdp, $user['password'])) {
        return true;
      }
    }
    return false;
  }
  public function hasAccount($nom, $prenom) {
    $allUser = $this->findAll();
    foreach ($allUser as $user) {
      # code...
      if($user['nom'] == $nom and $user['prenom']) {
        return true;
      }
    }
    return false;
  }
  public function getInfo(string $nom , string $prenom ){  
    $conditions = ['nom' => $nom, 'prenom' => $prenom];
    return $this->where($conditions);
  }
}

