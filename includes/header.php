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
    <link rel='icon' href="media/Logo.ico" type="image/x-icon" />

  </head>
  <body>
    <nav>
      <img src="img/Logo.png" width="50px" height="50px" align="center">
      <a href="index.php">Home</a>
      <a href="planning.php">Planning</a>
      <a href="addevent.php">Add-event</a>
      <a href="addcaretaker.php">Add-Caretaker</a>
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
