<?php

session_start();
include_once('api/user-pdo.php');

$user = new Userpdo();

// include 'api/db_connect.php';
// include 'api/user_auth.php';



if ($user->isConnected()) {
 
  if (isset($_GET['logout'])) {
  
    $user->disconnect();
  }
  
 
  header('Location: index.php');
  exit();
}


if(isset($_POST['register'])){
  if(!empty($_POST['login']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['password']) && !empty($_POST['re_password'])){
      $login=htmlspecialchars($_POST['login']);  //htmlspecialchar to secure the data
      $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : "";
      $firstname=htmlspecialchars($_POST['firstname']);
      $lastname=htmlspecialchars($_POST['lastname']);
      $password=htmlspecialchars($_POST['password']);
      $re_password=htmlspecialchars($_POST['re_password']);

      if ($password == $re_password) {

        if ($user->register($login, $email, $password, $firstname, $lastname)) {
          header('Location: inscription.php?success');
        }else {
          header('Location: inscription.php?error=2'); 
        }

        exit();

      } else {
          echo "<p class='err-msg'>passwords do not match</p>";
      }

      
  } else {
      echo "<p class='err-msg'>Veuillez completer tous les champs...</p>";
      
  }


}


$error = false;

if (isset($_GET['error'])){
  $error = true;

  switch ($_GET['error']) { 
    case 1;
      $msg = "Utilisateur déjà créé, ou login déjà pris";
      break;
    case 2;
      $msg = "Mots de passe différents";
      break;
    case 3;
      $msg = "Veuillez remplir tous les champs";
      break;
    default:
      $msg = "Erreur d'inscription";
    
 } 

}


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

    <title>Register Page | tdl</title>
</head>
<body class="horizontal-layout">

    <aside class="vertical-layout">
        <!-- Nom du site -->
        <h2 class="logo-name">tdl</h2>

        <?php $_GET['page'] = 'register'; $_GET['login'] = $user->login; include 'components/nav.php' ?>

        <?php include 'components/footer.php' ?>

    </aside>


    <main class="vertical-layout centered-layout">

      <?php if (isset($_GET['success'])) : ?>
      <div class="success container vertical flex-layout">
        <img class="mo-emoji" src="images/mo_emoji.png" alt="Mo Emoji"/>
        <h2>Votre compte a été créer </h2>
        <p>Vous pouvez maintenant vous connecter!</p>
        <a href="connexion.php"><button>me connecter</button></a>
      </div> 
      <?php else: ?>

      <h2>Créer votre compte &#128513;</h2>

        <?php if ($error) : ?>
        <p class='error msg'><?= $msg ?></p>
        <?php endif; ?>

      
      <form method="post">

      
        <input type="text" id="firstname" name="firstname" placeholder="First Name" required>

        <input type="text" id="lastname" name="lastname" placeholder="Last Name" required>

        <input type="text" id="login" name="login" placeholder="Login" value="<?= $user->login ?>" required>
           
        <input type="password" id="password" name="password" placeholder="Password"  required>
       
        <input type="password" id="re_password" name="re_password" placeholder="Confirm your password" required>

        <input type="email" id="email" name="email" placeholder="example@laplateforme.io" required>

        <button name="register">S'inscrire</button>
      </form>


      <?php endif; ?>

  </main>

</body>
</html>
