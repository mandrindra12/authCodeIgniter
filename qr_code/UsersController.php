<?php

namespace App\Controllers;
use App\Models\UtilisateursModel;
use CodeIgniter\Controller;
//use App\Controller\BaseController;

class UsersController extends BaseController{

    public function connection(){
        $database= new UtilisateursModel();
        $session= \Config\Services::session(); // charger session
        $data = [
            'nom' => $this->request->getvar("nom"),
            'prenom' => $this->request->getvar("prenom"),
            'mot_de_passe' => $this->request->getvar("mot_de_passe"),
        ];
        $user=$database->getConnect($data);
       /*if($user==null) return redirect()->to('http://gasy.codeigniter2.mg/');
       else{
        $session->set('userConnecter',$data); //Inserer le data dans la base de donnee
        //if($user['statut']==1){}
        echo 'Bienvenue '.$session->get('userConnecter')['nom'];
    }*/
   // print_r($user);
    if($user!=null && $user[0]['statut']==1) {
        echo 'Bienvenu Mr '.$user[0]['nom'].' ato amin page1';
    //        $session->destroy();
    }
    else if($user!=null && $user[0]['statut']==2){
        echo 'Bienvenu mpianatra '.$user[0]['nom'].' ato amin page1';
    }
    else
       return redirect()->to('http://gasy.codeigniter2.mg/');
}

    public function page(){
        $session=\Config\Services::session();
    $user=$session->get('userConnecter');
    if($user!=null && $user[0]['statut']==1) {
        echo 'Bienvenu Mr '.$user[0]['nom'].' ato amin page1';
    //        $session->destroy();
    }
    if($user!=null && $user[0]['statut']==2){
        echo 'Bienvenu mpianatra'.$user[0]['nom'].' ato amin page1';
    }
    else return redirect()->to('http://gasy.codeigniter2.mg/');
    }
   // return 


}$request= \Config\Services::request();