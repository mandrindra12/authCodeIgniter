<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    @font-face {
      font-family: popins;
      src: url(/assets/fonts/Poppins-Regular.ttf);
    }
    *{
      margin: 0;
      padding: 0;
      font-family: popins , sans-serif;
      box-sizing: border-box;
    }
    
    body {
     background-color: #f1f1f1;
      background-size: cover;
      background-position: center;
      width: 100vw;
      height: 100vh;
    }

    /* HEADER */

    .header-button{
      display:flex;
      width:50%;
      justify-content:right;
    }

    .header-title{
      font-size:20px;
    }

    .header-container{
      display:flex;
      align-items:center;
      width:100%;
      height:60px;
      padding:20px;
      border-bottom:1px solid #ccc;
    }
    .header-title{
      width:50%;
      align-items:left;
    }


    .link button {
            width: 200px;
            background-color: #FF3131;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
    }
    .link button:hover {
            background-color: #202124;
            color: #fff;
    }


    /* CONTAINER  */
    .container {
      width:100%;
      height:100%;
      padding:30px;
    }

    /* APPLICATION */
    .application-main-container{
      width:300px;
      height:350px;
      padding:20px;
      background-color:#fff;
      border-radius:10px;
      box-shadow: 0px 0px 20px #ccc;
    }
    
    .application-img{
      background-color:#ccc;
      width:100%;
      height:80%;
      border-radius:10px;
    }
    
    .application-title {
      padding: 5px;
      font-size:20px;
      border-bottom:1px solid #ccc;
    }

    .application-acces{
      padding:5px;
    }

    .application-link {
      background:#000;
      text-decoration:none;
      color:#000;
    }
  </style>
  <title>Accueil test</title>
</head>
<body>
  
</body>
</html>
<html>
  <header>
    <nav class="header-container">
      <div class="header-title">
        Accueil
      </div>
      <div class="header-button">
        <a href='/deconnexion' class="link"> 
          <button>
            Deconnexion 
          </button>  
        </a>
      </div>
    </nav>
  </header>
  <body>
    <!-- CONTAINER CODE -->
    <div class="container">
      <div class="application-main-container">
        <a href="/" class="application-link">
            <div class="application-img">
            </div>
            <div class="application-title">
              Title
            </div>
            <div class="application-acces">
              Acces : Teacher
            </div> 
        </a>
      </div> 
      <?php 
        if($data['statut'] == 1){
          echo "MR" . $data['nom'];
        } else {
          echo "Mpianatra" . $data['prenom'];
        }
      ?>
        
    </div>
  <body>
    <footter></footer>
</html>
