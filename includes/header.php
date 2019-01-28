<?php
session_start();
?>
<HTML>
  <head>
    <title><?php echo $title;?></title>
    <link rel="stylesheet" type="text/css" href="style.css"/>

    <meta charset="UTF-8">
    <meta name="Description" content="Author: S. C. Busters">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="57x57" href="icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="icons/favicon-16x16.png">
    <link rel="manifest" href="icons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffa700">
    <meta name="msapplication-TileImage" content="icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffa700">

  </head>
  <body>
    <nav>
      <img src="media/Logo.png"alt="Logo"  width="200px" height="100px" align="middle">
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
