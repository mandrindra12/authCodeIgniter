
<html>
  <body>
    OK Connecter 
    <?php 
    if($data['statut'] == 1){
      echo "MR" . $data['nom'];
    } else {
      echo "Mpianatra" . $data['prenom'];
    }

    ?>
    <a href='/deconnexion'> deconnexion </a>
  <body>

</html>
