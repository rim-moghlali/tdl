<?php   


include 'api/db_connect.php';
include 'api/user_auth.php';


if (!$connected){
  
  header('Location: connexion.php');
}


 
$sql = "SELECT `id` FROM `users` WHERE login = 'admin'";
$result = $conn->query($sql);
$admin = $result->fetch(PDO::FETCH_ASSOC);




$admin_id = $admin['id'];


if ($id != $admin_id) {
  
    header('Location: index.php');
}


$sql_users = "SELECT * FROM `users` WHERE id != '$admin_id'";

$result = $conn->query($sql_users);
$users = $result->fetchAll(PDO::FETCH_ASSOC);




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

    <title>Admin Page | tdl</title>
</head>


<body class="horizontal-layout">

    <aside class="vertical-layout">
        <!-- Nom du site -->
        <h2 class="logo-name">tdl</h2>

        <?php $_GET['page'] = 'admin'; $_GET['login'] = $login; include 'components/nav.php' ?>

        <?php include 'components/footer.php' ?>

    </aside>


    <main class="vertical-layout center-layout">

  
      <img id="logo" src="images/logo.gif" alt="Module Connexion Gif" />
   
      <h1 class="title">Liste des users</h1>

      <table>
          <thead>
              <tr>
                  <td>login</td>
                  <td>password</td>
              </tr>
          </thead>
          <tbody>
      
              <?php 
  
                  foreach ($users as $user) {
                      echo "
                      <tr>
                          <td class='login'><b>" . $user['login'] . "</b></td>
                          <td class='password'>" . $user['password'] . "</td>
                      </tr>
      
                      ";
                  }
              
              ?>
  
          </tbody>

      </table>

    </main>

</body>

</body>
</html>
