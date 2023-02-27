<?php

include 'api/db_connect.php';
include 'api/user_auth.php';


if (!$connected) { 
  header('Location: index.php');
} 


date_default_timezone_set('Europe/Paris');
$date = date('Y-m-d H:i:s');

$error = false;

if (isset($_GET['error'])){
  $error = true;

  switch ($_GET['error']) {
    case 1;
      $msg = "Veuillez remplir le champ de commentaire";
      break;
    default:
      $msg = "Erreur d'ajout de commentaire";
    
 } 

}


if(isset($_POST['comment'])){

  $comment = validate($_POST['comment']);

  // prepare a statement
  $statement = $conn->prepare("INSERT INTO `commentaires` (`commentaire`, `id_utilisateur`, `date`) VALUES (?, ?, ?)");
  // execute / run the statement
  $statement->execute(array($comment, $id, $date));

  header('Location: commentaire.php?success');
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

    <title>Commentaire | to-do list</title>
</head>
<body class="horizontal-layout">

    <aside class="vertical-layout">
        <!-- Nom du site -->
        <h2 class="logo-name">tdl</h2>

        <?php $_GET['page'] = 'commentaire'; $_GET['login'] = $login; include 'components/nav.php' ?>

        <?php include 'components/footer.php' ?>

    </aside>


    <main class="vertical-layout centered-layout">

        <div class="container center-layout">

            <?php if (isset($_GET['success'])) : ?>
            <p class="success msg">Commentaire ajoute</p>
            <?php endif; ?>

            <h2>Ajouter votre commentaire</h2>

            <img class="comment" src="images/comment.gif" alt="comment gif" />

            <?php if ($error) : ?>
            <p class='error msg'><?= $msg ?></p>
            <?php endif; ?>


            <form method="post">

                <textarea id="comment" name="comment" required autofocus></textarea>
                <button>Ajouter</button>

            </form>

        </div>

    </main>

</body>
</html>
