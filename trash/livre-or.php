<?php

include 'api/db_connect.php';
include 'api/user_auth.php';

$result = $conn->query("SELECT `commentaire`, `login`, `date` FROM `commentaires`
INNER JOIN `users`
ON commentaires.id_utilisateur = users.id
ORDER BY `date` DESC");

$comments = $result->fetchAll(PDO::FETCH_ASSOC);


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

    <title>to-do list</title>
</head>
<body class="horizontal-layout">

    <aside class="vertical-layout">
        <!-- Nom du site -->
        <h2 class="logo-name">tdl</h2>

        <?php $_GET['page'] = 'todolist'; $_GET['login'] = $login; include 'components/nav.php' ?>

        <?php include 'components/footer.php' ?>

    </aside>


    <main class="vertical-layout centered-layout">
        <?php if ($connected) : ?>
            <a class="fab" href="commentaire.php" title="ajouter un commentaire">
                <button>
                    <span class="material-icons">add</span>
                </button>
            </a>
        <?php endif; ?>

        <img id="logo" src="images/logo-book.gif" alt="Livre Or Gif" />

        <table>
            <thead>
                <tr>
                    <td>Posted On</td>
                    <td>Users</td>
                    <td>Comments</td>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($comments as $comment) : ?>

                <tr>
                    <td><?= $comment['date'] ?></td>
                    <td><?= $comment['login'] ?></td>
                    <td><?= $comment['commentaire'] ?></td>
                </tr>

                <?php endforeach; ?>
            </tbody>
        </table>

    </main>

</body>
</html>