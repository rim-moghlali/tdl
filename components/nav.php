
<?php if ($connected) : ?>

<nav class="vertical-layout">
  <a href="index.php" <?= $_GET['page'] == 'home' ? 'active' : '' ?> >
      <span class="material-icons">home</span>
      <span>Accueil</span>
  </a>
  
    <?php if ($_GET['login'] === 'admin') : ?>

    <a href="admin.php" <?= $_GET['page'] == 'admin' ? 'active' : '' ?>>
      <span class="material-icons">people</span>
      <span>Utilisateurs</span>
    </a>

    <?php endif; ?>


  <a href="profil.php" <?= $_GET['page'] == 'profile' ? 'active' : '' ?> >
      <span class="material-icons">person</span>
      <span>Profil</span>
  </a>

  <a href="tdl.php" <?= $_GET['page'] == 'tdl' ? 'active' : '' ?> >
      <span class="material-icons">menu_book</span>
      <span>to-do list</span>
  </a>

  <a href="commentaire.php" <?= $_GET['page'] == 'commentaire' ? 'active' : '' ?> >
      <span class="material-icons">chat_bubble</span>
      <span>Commentaire</span>
  </a>
 
  <a href="connexion.php?logout" >
      <span class="material-icons">logout</span>
      <span>Se deconnecter</span>
  </a>

</nav>


<?php else : ?>


<nav class="vertical-layout">
  <a href="index.php" <?= $_GET['page'] == 'home' ? 'active' : '' ?> >
      <span class="material-icons">home</span>
      <span>Accueil</span>
  </a>

  <a href="connexion.php" <?= $_GET['page'] == 'login' ? 'active' : '' ?> >
      <span class="material-icons">login</span>
      <span>Connexion</span>
  </a>

  <a href="inscription.php" <?= $_GET['page'] == 'register' ? 'active' : '' ?> >
      <span class="material-icons">person_add</span>
      <span>Inscription</span>
  </a>

  <a href="tdl.php" <?= $_GET['page'] == 'tdl' ? 'active' : '' ?> >
      <span class="material-icons">menu_book</span>
      <span>to-do list</span>
  </a>
  
</nav>


<?php endif; ?>
