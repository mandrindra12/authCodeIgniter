<?php

namespace App\Controllers;
use App\Models\UtilisateursModel;
use CodeIgniter\Controller;
use App\Models\UserModel;

class UsersController extends BaseController{

    public function connection(){
        $database = new UserModel();
        $session= \Config\Services::session(); // charger session
        $user = $database->hasAccount($this->request->getJsonVar('nom'), $this->request->getJsonVar('prenom'));
        $data = [
            'nom' => $this->request->getvar("nom"),
            'prenom' => $this->request->getvar("prenom"),
            'mot_de_passe' => $this->request->getvar("mot_de_passe"),
            'statut' => $user
        ];
       if($user <= 0) return redirect()->route('/');
       else{
        $session->set('userConnecter',$data); //Inserer le data dans la base de donnee
        echo 'Bienvenue '.$session->get('userConnecter')['nom'];
    }
    }

    public function page(){
        $session=\Config\Services::session();
    $user=$session->get('userConnecter');
    if($user!=null) {
        echo 'Bienvenu '.$user['nom'].' ato amin page1';
    //        $session->destroy();
    }
    else //'Tsy vanona ela le'; 
    return redirect()->to('/');
    }
   // return 


}$request= \Config\Services::request();
