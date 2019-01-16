<?php
session_start();
?>
<HTML>
  <head>
    <title><?php echo $title;?></title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
  </head>
  <body>
    <nav>
      <a href="/">Home</a>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
      <a href="planning.php">Planning</a>
      <a href="addevent.php">Add-event</a>
      <?php
      if($_SESSION['loggedIn']) {
        ?>
        <span>Welcome <?php echo $_SESSION['username'];?>.</span>
        <?php
      }
      ?>
    </nav>
