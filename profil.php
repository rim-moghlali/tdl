<?php

include 'api/db_connect.php';
include 'api/user_auth.php';



if (!$connected) { 
 
  header('Location: index.php');
} 

    

if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['re_password'])){


  $new_login = validate($_POST['login']);

  $new_password = validate($_POST['password']);
  $new_re_password = validate($_POST['re_password']);

 

  if ($new_login !== '' && $new_password !== '' && $new_re_password !== '') {

    // echo "login => $new_login";
    // echo "password => $new_password";
    echo "re_password => $new_re_password";
    
   
    if($new_password == $new_re_password) {
       
     
      $sql_search_user = "SELECT COUNT(*) FROM utilisateurs where login = '$new_login'";
      $result = $conn->query($sql_search_user);
      
      $count = $result->fetchColumn();


      echo "login => $login";
      echo "new_login => $new_login";

      echo "count: ";
      var_dump($count);

     
      if ($new_login === $login || $count === '0') {

   
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
       
        $sql_new_user = "UPDATE `utilisateurs` SET 
          login = '$new_login', 
          password = '$new_password' 
          WHERE id = '$id'
        ";
          
        $conn->exec($sql_new_user);

        header('Location: profil.php?success');

      } else{
        header('Location: profil.php?error=1'); 
      }

    } else{
        header('Location: profil.php?error=2'); 
    }

  } else {
      header('Location: profil.php?error=3'); 
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

    <title>Profile Page | tdl</title>
</head>
<body class="horizontal-layout">

    <aside class="vertical-layout">
 
        <h2 class="logo-name">tdl</h2>

        <?php $_GET['page'] = 'profile'; $_GET['login'] = $login; include 'components/nav.php' ?>
         
        <?php include 'components/footer.php' ?>


    </aside>


    <main class="vertical-layout centered-layout">

      <div class="container center-layout">

        <?php if (isset($_GET['success'])) : ?>
        <p class="success msg">Profil modifié</p>
        <?php endif; ?>

        <h2>Modifier votre Profil</h2>

        <img src="images/avatar.png" alt="avatar" />

          <?php if ($error) : ?>
          <p class='error msg'><?= $msg ?></p>
          <?php endif; ?>

    
        <form method="post">


         
          <input type="text" id="login" name="login" placeholder="Login" value="<?= $login ?>" <?= $login == 'admin' ? 'disabled' : '' ?> required>
         
          <input type="password" id="password" name="password" placeholder="Password"  required>
        
          <input type="password" id="re_password" name="re_password" placeholder="Confirmer votre password" required>
        
          <button>Modifier Profil</button>
        </form>

      </div>


  </main>

</body>
</html>
