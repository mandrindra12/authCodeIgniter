<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PersonModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController extends BaseController
{
    protected $usermodel;
    protected $personmodel;
    public function __construct()
    {
        $this->usermodel = new UserModel();
        $this->personmodel = new PersonModel();
    }
    public function index(): string
    {
        return view('login');
    }

	public function forgetPassword(){
		return view('forgetPassword');
	}

    public function newPassword(){
        return view('newPassword');
    }
    
    public function sendMail(){
        $request=\Config\Services::request();
        $destinataires=$request->getvar('mail');
        $name='';
        sprintf($destinataires,"%s@mit-ua.mg",$name);
        $mail = new PHPMailer(true);
        try{
            // SMTP settings
            $mail->isSMTP();
            $mail->Host = 'mail.mit-ua.mg';
            $mail->SMTPAuth = true;
            $mail->Username = 'mandriamahenintsoa@mit-ua.mg';
            $mail->Password = '*sz$v^19^p!e';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
        
            // Sender and reply-to
            $mail->setFrom('mandriamahenintsoa@mit-ua.mg', 'Andriamahenintsoa');
            $mail->addReplyTo($destinataires,$name );
        
            // Add the recipient
            $mail->addAddress($destinataires, $name);
        
            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Nouveau mot de passe';
            $mail->Body    = 'Voici le mail pour renouveler le mot de passe <a href="localhost:8080/new-password" > Click </a>';
           // $mail->addAttachment($pdf);
        
            $mail->send();
            echo "Message has been sent\n";
           return redirect()->to("/");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}\n";
        }

    }
    public function inscriptionIndex(): string
    {
        return view('signup');
    }
    public function accueil(): \CodeIgniter\HTTP\RedirectResponse | string
    {
        $s = \Config\Services::session();
        $data = $s->get('ConnectedUser');
        if ($data == null) {
            return redirect()->route('/');
        }
        return view('accueil', ['data' => $data]);
    }
    public function qrConnexion(): \CodeIgniter\HTTP\ResponseInterface
    {
        $nom = $this->request->getGet('Nom');
        $prenom = $this->request->getGet('Prenom');
        $users = $this->usermodel->getInfo($nom, $prenom);
        $userStatus = $this->usermodel->hasAccount($nom, $prenom);
        if (!empty($userStatus) and !empty($users)) {
            // if ($user['est_actif'] == 1) {
            //   // json_encode(['status' => 'user already logged in', 'status_code' => 200]);
            //   return $this->response
            //     ->setContentType('application/json')
            //     ->setStatusCode(403)
            //     ->setJSON(['status' => 'user already logged in']);
            // }
            $prefix = ($userStatus[0]['statut'] == 1) ? "Monsieur" : "Etudiant(e)";
            $user = $users[0];
            $this->usermodel->connexion($user['nom'], $user['prenoms']);
            $data = [
              'id' => $user['id_personne'],
              'nom' => $user["nom"],
              'prenom' => $user["prenoms"],
              'mot_de_passe' => $user["mot_de_passe"],
              'statut' => $userStatus[0]['statut'],
              'prefix' => $prefix
            ];
            $this->setSession($data);
            return $this->response
              ->setContentType('application/json')
              ->setStatusCode(200)
              ->setJSON(['status' => 'log in successful']);
        }
    }
    public function connexion(): \CodeIgniter\HTTP\ResponseInterface
    {
        $nom = $this->request->getJsonVar('nom');
        $prenom = $this->request->getJsonVar('prenom');
        $mdp = $this->request->getJsonVar('password');
        $users = $this->usermodel->getInfo($nom, $prenom);
        $userStatus = $this->usermodel->hasAccount($nom, $prenom);
        if (empty($userStatus)) {
            // echo json_encode(['status' => 'user not found', 'status_code' => 404]);
            return $this->response
              ->setContentType('application/json')
              ->setStatusCode(404)
              ->setJSON(['status' => 'user not found']);
        }
        // return $this->response->setJSON(['statut' => $users]);
        foreach ($users as $user) {
            if ($this->usermodel->verifyPassword($user['nom'], $user['prenoms'], $mdp)) {
                // if ($user['est_actif'] == 1) {
                //   // json_encode(['status' => 'user already logged in', 'status_code' => 200]);
                //   return $this->response
                //     ->setContentType('application/json')
                //     ->setStatusCode(403)
                //     ->setJSON(['status' => 'user already logged in']);
                // } else
                if ($this->usermodel->connexion($user['nom'], $user['prenoms']) or $user['est_actif'] == 1) {
                    // echo json_encode(['status' => 'loggin successful', 'status_code' => 200]);
                    $prefix = ($userStatus[0]['statut'] == 1) ? "Monsieur" : "Etudiant(e)";
                    $data = [
                      'id' => $user['id_personne'],
                      'nom' => $user["nom"],
                      'prenom' => $user["prenoms"],
                      'mot_de_passe' => $user["mot_de_passe"],
                      'statut' => $userStatus[0]['statut'],
                      'prefix' => $prefix
                    ];
                    // if($user <= 0) return redirect()->route('/');
                    $this->setSession($data);
                    return $this->response
                      ->setContentType('application/json')
                      ->setStatusCode(200)
                      ->setJSON(['status' => 'log in successful']);
                }
            } else {
                // echo json_encode(['status' => 'incorrect password', 'status_code' => 200]);
                return $this->response
                  ->setContentType('application/json')
                  ->setStatusCode(403)
                  ->setJSON(['status' => 'incorrect password']);
            }
        }
        return view('500.html');
    }
    public function inscription(): \CodeIgniter\HTTP\ResponseInterface
    {
        $userdata = $this->request->getJSON(true);
        if (!$this->personmodel->exist($userdata['nom'], $userdata['prenom'])) {
            // echo json_encode(['status' => 'no person found for this name in mit/misa', 'status_code'=> 404]);
            return $this->response->setContentType('application/json')->setStatusCode(404)
              ->setJSON(['status' => 'no person found for this name in MIT/MISA']);
        } elseif ($this->usermodel->hasAccount($userdata['nom'], $userdata['prenom'])) {
            // echo json_encode(['status' => 'user has already an account, abort...', 'status_code' => 400]);
            return $this->response->setContentType('application/json')->setStatusCode(400)
              ->setJSON(['status' => 'user has already an account, Abort...']);
        } else {
            $infoPerson = $this->personmodel->getRelativeInfo($userdata['nom'], $userdata['prenom']);
            $hashedpassword = password_hash($userdata['password'], PASSWORD_BCRYPT);
            $data = array(
              'nom' => $userdata['nom'],
              'prenoms' => $userdata['prenom'],
              'mot_de_passe' => $hashedpassword,
              'id_personne' => $infoPerson[0]['id_personne'],
              'statut' => $infoPerson[0]['id_statut']
            );
            $this->usermodel->inscription($data);
            return $this->response->setContentType('application/json')->setStatusCode(201)->setJSON(['status' => 'registration successful']);
        }
    }
    private function setSession($data): void
    {
        $session = \Config\Services::session(); // charger session
        $session->set('ConnectedUser', $data);
    }
    public function deconnexion(): \CodeIgniter\HTTP\RedirectResponse
    {
        $session = \Config\Services::session();
        $sessionData = $session->get('ConnectedUser');
        $this->usermodel->deconnexion($sessionData['id']);
        $session->destroy();
        return redirect()->route('/');
    }
}
