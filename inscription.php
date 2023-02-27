<?php

include 'api/db_connect.php';
include 'api/user_auth.php';



if ($connected) {
 
  if (isset($_GET['logout'])) {
  
    session_unset();
  }
  
 
  header('Location: index.php');
}



if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['re_password'])){


  $login = validate($_POST['login']);
  $password = validate($_POST['password']);
  $re_password = validate($_POST['re_password']);

 

  if ($login !== '' && $password !== '' && $re_password !== '') {

    echo "login => $login";
    echo "password => $password";
    echo "re_password => $re_password";
    
   
    if($password == $re_password){
      
    
      $sql_search_user = "SELECT COUNT(*) FROM utilisateurs where login = '$login'";
      $result = $conn->query($sql_search_user);
    
      $count = $result->fetchColumn();
    

      
      if($count == 0){ 

        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql_new_user = "INSERT INTO utilisateurs (login, password) VALUES ('$login', '$password')";
        $conn->exec($sql_new_user);

        header('Location: inscription.php?success');

      } else{
        header('Location: inscription.php?error=1'); 
      }

    } else{
        header('Location: inscription.php?error=2'); 
    }

  } else {
      header('Location: inscription.php?error=3'); 
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

        <?php $_GET['page'] = 'register'; $_GET['login'] = $login; include 'components/nav.php' ?>

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


        <input type="text" id="login" name="login" placeholder="Login" value="<?= $login ?>" required>
           
        <input type="password" id="password" name="password" placeholder="Password"  required>
       
        <input type="password" id="re_password" name="re_password" placeholder="Confirmer votre password" required>
     
        <button>S'inscrire</button>
      </form>


      <?php endif; ?>

  </main>

</body>
</html>
