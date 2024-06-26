<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
  protected $table = 'utilisateurs';
  protected $builder;
  protected $db;
  protected $primaryKey = 'id_utilisateur';
  // public $db = \Config\Database::connect();
  protected $allowedFields = ['id_utilisateur', 'id_personne', 'nom', 'prenoms', 'mot_de_passe', 'est_actif', 'statut'];
  public function __construct()
  {
    // $builder = $db->table($this->table);
    $this->db = db_connect();
    $this->builder = $this->db->table($this->table);
  }
  // ATY NO INSERTION ANATY DATABASE
  public function inscription($data): bool|int|string
  {
    return $this->insert($data);
  }
  //
  public function connexion(string $nom, string $prenoms): bool
  {
    $conditions = ['nom' => $nom, 'prenoms' => $prenoms];
    $this->builder->set('est_actif', 1)->where($conditions)->update();
    return true;
  }
  public function verifyPassword(string $nom, string $prenom, string $mdp): bool
  {
    $conditions = ['nom' => $nom, 'prenoms' => $prenom];
    $users = $this->builder->where($conditions)->get()->getResultArray();
    foreach ($users as $user) {
      if (password_verify($mdp, $user['mot_de_passe'])) {
        return true;
      }
    }
    return false;
  }
  public function hasAccount(string $nom, string $prenom): array
  {
    $c = array('nom' => $nom, 'prenoms' => $prenom);
    $count = 0;
    $count = $this->builder->select('id_personne, statut')->where($c)->get()->getResultArray();
    return $count;
  }
  public function getInfo($nom, $prenom): array
  {
    $conditions = ['nom' => $nom, 'prenoms' => $prenom];
    return $this->builder->where($conditions)->get()->getResultArray();
  }
  public function deconnexion($id): void
  {
    $this->builder->set('est_actif', 0)->where('id_personne', $id)->update();
  }
}
