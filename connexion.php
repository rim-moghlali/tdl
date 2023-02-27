<?php

include 'api/db_connect.php';
include 'api/user_auth.php';



if ($connected) {
   
    if (isset($_GET['logout'])) {
        
        session_unset();
    }
    

    header('Location: index.php');
} 

    
if (isset($_POST['login']) && isset($_POST['password'])){

    $login = validate($_POST['login']);
    $password = validate($_POST['password']);

    $result = $conn->query("SELECT * FROM `utilisateurs` WHERE login = '$login'");
    $user = $result->fetch(PDO::FETCH_ASSOC);
    


    if ($user) {
        
        
        $hash_password = $user['password'];

      

        if (password_verify($password, $hash_password)) { 
            
          $_SESSION['id'] = $user['id'];

          header('Location: index.php');
            
        }else {
            header('Location: connexion.php?error=2');
        }


    } else {
        header('Location: connexion.php?error=1');
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

    <title>Login Page | tdl</title>
</head>
<body class="horizontal-layout">

    <aside class="vertical-layout">
        <!-- Nom du site -->
        <h2 class="logo-name">tdl</h2>

        <?php $_GET['page'] = 'login'; $_GET['login'] = $login; include 'components/nav.php' ?>

        <?php include 'components/footer.php' ?>

    </aside>


    <main class="vertical-layout centered-layout">

      <h2>Hello &#128075;!</h2>

     
      <form method="post">


        <?php 
        if(isset($_GET['error'])){
            $err = (int) $_GET['error'];
            $msg = "";
    
            switch ($err) {
                case 1:
                    $msg = "login ou mot de passe incorrecte";
                    break;
                case 2:
                    $msg = "Mot de passe incorrecte";
                    break;
                default:
                    $msg = "Erreur de connexion";
                }
    
            echo "<p class='error msg'>$msg</p>";
    
        }
        
        ?>

       
        <input type="text" id="login" name="login" placeholder="Login" required>
        
        <input type="password" id="password" name="password" placeholder="Password" required>
     
        <button>Connexion</button>
      </form>

  </main>

</body>
</html>
