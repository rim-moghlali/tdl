<?php

// start the session
session_start();

// Initialize login, prenom and nom variables
$login = '';
$prenom = '';
$nom = '';

// set the connected variable to FALSE because user 
// is not yet connected, we assume / by default
$connected = false;

// If an `id` session variable exists
if (isset($_SESSION['id'])) {
    // get that id
    $id = $_SESSION['id'];
    // select the login from the `utilisateurs` table of this user w/ `id`
    $result = $conn->query("SELECT login FROM `utilisateurs` WHERE id = '$id'");
    $user = $result->fetch(PDO::FETCH_ASSOC);

    // TEST
    //var_dump($user);
    // $arr1 = [20, 33]; // indexed array
    // $arr2 = ['one' => 20, 'two' => 33]; // associative array
    // $arr1 = [20, 33];

    // var_dump($arr1);
    // $first_item_from_arr1 = $arr1[0];
    // echo $first_item_from_arr1;

    // var_dump($arr2);
    // $second_item_from_arr2 = $arr2['two'];
    // echo $second_item_from_arr2; 
    // var_dump($user);
    // END OF TEST
    
    if ($user) {
      // hurray, our user is connected 
      $connected = true;

      // update the predefined variables
      $login = $user['login'];
    }

}


function validate($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}

?>
