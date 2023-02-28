<?php

session_start();
include_once('api/user-pdo.php');

$user = new Userpdo();

// include 'api/db_connect.php';
// include 'api/user_auth.php';

// session_unset();

// if ($user->isConnected()) {
//   $user->disconnect();
//   echo "you are connected";
// }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="style.css">

    <title>Home Page | tdl</title>
</head>
<body class="horizontal-layout">

    <aside class="vertical-layout">
        <!-- Nom du site -->
        <h2 class="logo-name">tdl</h2>

        <?php $_GET['page'] = 'home'; $_GET['login'] = $user->login; include 'components/nav.php' ?>

        <?php include 'components/footer.php' ?>

    </aside>


    <main class="vertical-layout centered-layout">
      <?php if ($user->isConnected()): ?>
  
      <div class="container" connected fit>
        <h1 class="title">Bonjour <span><?= $user->firstname ?></span></h1> 
      </div>


      <?php else: ?>

     
      <img id="logo" src="images/logo-book.gif" alt="Livre Or Gif" />
     
      <h1 class="title">Bienvenue à mon to-do list</h1>
     
      <p>Connecter vous pour utiliser ce site et ajouter une tache dans votre liste to-do.</p>

      <?php endif; ?>

    </main>

</body>
</html>
