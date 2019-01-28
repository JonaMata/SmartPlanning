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
      <div id="menuToggle">
        <!--
          A fake / hidden checkbox is used as click reciever,
          so you can use the :checked selector on it.
        -->
        <input type="checkbox" />

        <!--  Some spans to act as a hamburger.  -->
        <span></span>
        <span></span>
        <span></span>

        <ul id="menu">
          <?php
          if($_SESSION['loggedIn']) {
            ?>
            <p>Welcome <?php echo $_SESSION['username'];?>.</p>
            <?php
          }
          ?>
          <li><a href="index.php">Home</a></li>
          <li><a href="
          <?php
          if($_SESSION['type'] == "caretaker"){
            echo "choose_user.php";
          }
          else{
            echo "planning.php";
          }

          ?>
          ">Planning</a></li>
          <li><a href="addevent.php">Add-event</a></li>
          <?php
          if($_SESSION['loggedIn']) {
            ?>
            <li><a href="logout.php">Log out</a></li>
            <?php
          }
          else{
            ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
            <?php
          }
          ?>
        </ul>
      </div>
    </nav>
    <div id="content">
