
<?php if ($user->isConnected()) : ?>

<nav class="vertical-layout">
  <a href="index.php" <?= $_GET['page'] == 'home' ? 'active' : '' ?> >
      <span class="material-icons">home</span>
      <span>Accueil</span>
  </a>


  <a href="profil.php" <?= $_GET['page'] == 'profile' ? 'active' : '' ?> >
      <span class="material-icons">person</span>
      <span>Profil</span>
  </a>

  <a href="todolist.php" <?= $_GET['page'] == 'todolist' ? 'active' : '' ?> >
      <span class="material-icons">menu_book</span>
      <span>to-do list</span>
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
  
</nav>


<?php endif; ?>
