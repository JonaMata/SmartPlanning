<?php
$title = 'add people';
require('includes/header.php');


if($_SERVER['REQUEST_METHOD'] === 'POST') {
  require('includes/database.php');
?>

  <form method="POST">
  <?php
    /* check if the user is caretaker or care receiver */
    if ($_POST['type'] = 1){
      echo("
      '<input type=\"hidden\" name=\"user\" />
      Username: <input type=\"username\" name=\"caretaker\" />'
      ")
    }
    else if ($_POST['type'] = 0){
      echo("
      '<input type=\"hidden\" name=\"caretaker\" />
      Username: <input type=\"username\" name=\"user\" />'
      ")
    }
    else{
      die("Error loading user");  /* Not the nicest but works for now ¯\_(ツ)_/¯  */
    }
  ?>

    <input type="submit" value="submit">
  </form>';
