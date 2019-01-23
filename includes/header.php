<?php
session_start();
?>
<HTML>
  <head>
    <title><?php echo $title;?></title>
    <link rel="stylesheet" type="text/css" href="style.css"/>

    <meta charset="UTF-8">
    <meta name="Description" content="Author: S. C. Busters">
    <meta name="theme-color" content="#502D4B">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='icon' href="media/logotemp.ico" type="image/x-icon" />

  </head>
  <body>
    <nav>
      <a href="index.php">Home</a>
      <a href="
      <?php
      if($_SESSION['type'] == "caretaker"){
        echo "choose_user.php";
      }
      else{
        echo "planning.php";
      }
      
      ?>
      ">Planning</a>
      <a href="addevent.php">Add-event</a>
      <?php
      if($_SESSION['loggedIn']) {
        ?>
        <a href="logout.php">Log out</a>
        <span>Welcome <?php echo $_SESSION['username'];?>.</span>
        <?php
      }
      else{
        ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <?php
      }
      ?>
    </nav>
    <div id="content">
