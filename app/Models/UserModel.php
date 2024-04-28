<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
  protected $table = 'utilisateurs';
  protected $builder;
  protected $db;
  // public $db = \Config\Database::connect();
  protected $allowedFields = ['id_utilisateur', 'id_personne', 'nom', 'prenoms', 'mot_de_passe', 'est_actif', 'statut'];
  public function __construct() {
    // $builder = $db->table($this->table);
    $this->db = db_connect();
    $this->builder = $this->db->table($this->table);
  }
  // ATY NO INSERTION ANATY DATABASE
  public function inscription($data) {
    return $this->insert($data);
  }
  // 
  public function connexion(string $nom, string $prenoms, string $mdp) : bool {
    $conditions = ['nom' => $nom, 'prenoms' => $prenoms, 'password' => $mdp];
    $this->set(['est_actif', 1])->where($conditions)->update();
    return true;
  }
  public function verifyPassword(string $nom, string $prenom, $mdp) {
    $conditions = ['nom' => $nom, 'prenoms' => $prenom];
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
  public function getInfo($nom , $prenom ){  
    $conditions = ['nom' => $nom, 'prenoms' => $prenom];
    return $this->builder->where($conditions);
  }
}

