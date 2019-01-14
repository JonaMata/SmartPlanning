<?php error_reporting(E_ALL);
ini_set('display_errors', 1); ?>

<?php
$title = 'Register';
require('includes/header.php');

if(isset($_POST)) {
  require('includes/database.php');

  $query = $conn->prepare("INSERT INTO users (username, email, password, type, planning_userid) VALUE (?, ?, ?, ?, ?)");
  //$query->bind_param('sssii', $_POST['username'], $_POST['email'], $_POST['password'], $_POST['type'], $_POST['planning_userid']);
  //$query->execute();

  //header('Location: /');

}



?>

<form method="POST">
  Username: <input type="username" name="username"><br>
  E-mail: <input type="email" name="username"><br>
  Password: <input type="password" name="password"><br>
  Repeat password: <input type="password" name="password-check"><br>
  <button type="submit">Register</button>
</form>

<?php
require('includes/footer.php');
?>
