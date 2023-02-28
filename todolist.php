<?php

session_start();
include_once('api/user-pdo.php');

$user = new Userpdo();

if (!$user->isConnected()) {
    echo "user is not connected!!!";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>to-do list</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="todolist.css">

    <script src="todolist.js"></script>

</head>
<body class="horizontal-layout">

    <aside class="vertical-layout">
        <!-- Nom du site -->
        <h2 class="logo-name">tdl</h2>

        <?php $_GET['page'] = 'todolist'; $_GET['login'] = $user->login; include 'components/nav.php' ?>

        <?php include 'components/footer.php' ?>

    </aside>


    <main class="vertical-layout centered-layout">
        <!-- <h1>Welcome <b><?= $user->getFirstName() . " " . $user->getLastName(); ?></b></h1> -->

        <section id="allTodos">
            <h2>My TO DO LISTS</h2>
            <button onclick="showCompletedTodos()">Show Completed Todos</button>

            <ul class="todo-list-container">

                <li id="creator">
                    <textarea id="newList" type="text" placeholder="New List" maxlength="50"></textarea>
                    <button id="createTodolist" onclick="createTodolist()">Create Todolist</button>
                </li>
                
            </ul>

        </section>

        <section id="completedTodos">
            <h2>Completed Todos</h2>
            <button onclick="showAllTodos()">Show All Todos</button>
        </section>

    </main>

</body>
</html>