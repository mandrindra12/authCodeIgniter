<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PersonModel;

class UserController extends BaseController {
  protected $usermodel;
  protected $personmodel;
  public function __construct() {
    $this->usermodel = new UserModel();
    $this->personmodel = new PersonModel();
  }
  public function index() {
    return view('login');
  }
  public function inscriptionIndex() {
    return view('signup');
  }
  public function accueil() {
    return view('accueil');
  }
  public function connexion() {
    $nom = $this->request->getJsonVar('nom');
    $prenom = $this->request->getJsonVar('prenom');
    $mdp = $this->request->getJsonVar('password');
    // $nom = $this->request->getPost('nom');
    // $prenom = $this->request->getPost('prenom');
    // $mdp = $this->request->getPost('password');
    // $numrow = 0;
    // $hasAccount = $this->usermodel->hasAccount($nom, $prenom);
    // return $this->response->setContentType('application/json')->setJSON(['status' => $nom, $prenom, $mdp]);
    if(!$this->usermodel->hasAccount($nom, $prenom)) { 
      // echo json_encode(['status' => 'user not found', 'status_code' => 404]);
      return $this->response
                  ->setContentType('application/json')
                  ->setStatusCode(404)
                  ->setJSON(['status' => 'user not found']);
    }
    $users = $this->usermodel->getInfo($nom, $prenom);
    foreach ($users as $user) {
      if($this->usermodel->verifyPassword($user['nom'], $user['prenoms'], $mdp)) {
        if($user['est_actif'] == 1) {
          // json_encode(['status' => 'user already logged in', 'status_code' => 403]);
          return $this->response
                      ->setContentType('application/json')
                      ->setStatusCode(403)
                      ->setJSON(['status' => 'user already logged in']);
        } else if($this->usermodel->connexion($user['nom'], $user['prenoms'], $user['mot_de_passe'])) {
          // echo json_encode(['status' => 'loggin successful', 'status_code' => 200]);
          return $this->response
                      ->setContentType('application/json')
                      ->setStatusCode(200)
                      ->setJSON(['status' => 'log in successful']);
        } 
      } else {
        // echo json_encode(['status' => 'incorrect password', 'status_code' => 403]);
        return $this->response
                    ->setContentType('application/json')
                    ->setStatusCode(403)
                    ->setJSON(['status' => 'incorrect password']);
      }
    }
  }
  public function inscription() {
    $userdata = $this->request->getJSON(true);
    if(!$this->personmodel->exist($userdata['nom'], $userdata['prenom'])) {
      // echo json_encode(['status' => 'no person found for this name in mit/misa', 'status_code'=> 404]);
      return $this->response->setContentType('application/json')->setStatusCode(404)
                  ->setJSON(['status' => 'no person found for this name in MIT/MISA']);
    } else if($this->usermodel->hasAccount($userdata['nom'], $userdata['prenom'])) {
      // echo json_encode(['status' => 'user has already an account, abort...', 'status_code' => 400]);
      return $this->response->setContentType('application/json')->setStatusCode(400)
                  ->setJSON(['status' => 'user has already an account, Abort...']);
    } else {
      $infoPerson = $this->personmodel->getRelativeInfo($userdata['nom'], $userdata['prenom']);
      $hashedpassword = password_hash($userdata['password'], PASSWORD_BCRYPT);
      $data = array('nom' => $userdata['nom'],
                    'prenoms' => $userdata['prenom'],
                    'mot_de_passe' => $hashedpassword,
                    'id_personne' => $infoPerson[0]['id_personne'],
                    'statut' => $infoPerson[0]['id_statut']
      );
      $this->usermodel->inscription($data);
      return $this->response->setContentType('application/json')->setStatusCode(201)->setJSON(['status' => 'registration successful']);
    }
  }
}

