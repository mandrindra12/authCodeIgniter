<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PersonModel;

class UserController extends BaseController {
  private $userModel;
  private $personModel;
  public function __construct() {
    $this->userModel = new UserModel();
    $this->personModel = new PersonModel();
  }
  public function index() {
    return view('login');
  }
  public function connexion() {
    $nom = $this->request->getJsonVar('nom');
    $prenom = $this->request->getJsonVar('prenom');
    $mdp = $this->request->getJsonVar('password');
    $numRow = $this->userModel->getInfo($nom, $prenom)->countAllResults();
    if($numRow <= 0) {
      echo json_encode(['status' => 'user not found', 'status_code' => 404]);
      return 404;
    }
    $users = $this->userModel->getInfo()->get()->getResultArray();
    for($i = 0; $i<numRow; $i++) {
      // if(password_verify($mdp, $users['password']) {}
        // if($users['est_actif'] == 1) {
        //   echo json_encode(['status' => 'user already logged in' , 'status_code' => 403]);
        //   return 403;
        // } else if($this->userModel->connexion()){
        //   echo json_encode(['status' => 'login successful', 'status_code' => 202]);
        //   return 202;
        // }
      // }
      if($this->userModel->verifyPassword($user['nom'], $user['prenom'], $mdp)) {
        if($user['est_actif'] == 1) {
          json_encode(['status' => 'user already logged in', 'status_code' => 403]);
          return 403;
        } else if($this->userModel->connexion()) {
          echo json_encode(['status' => 'loggin successful', 'status_code' => 202]);
          return 0;
        } 
      }
    }
  }
  public function inscription() {
    $userData = $this->request->getJSON(true);
    if(!$this->personModel->exist($userData['nom'], $userData['prenom'])) {
      echo json_encode(['status' => 'no person found for this name in MIT/MISA', 'status_code'=> 404]);
      return 404;
    } else if($this->userModel->hasAccount($userData['nom'], $userData['prenom'])) {
      echo json_encode(['status' => 'user has already an account, abort...', 'status_code' => 400]);
      return 500;
    } else {
      $hashedPassword = password_hash($userData['password'], PASSWORD_BCRYPT);
      $data = array('nom' => $userData['nom'], 'prenom' => $prenom, 'password' => $hashedPassword);
      $this->inscription($data);
    }
  }
  public function inscriptionIndex() {
    return view('signup');
  }
}

