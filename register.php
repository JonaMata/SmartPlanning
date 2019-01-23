<?php
$title = 'Register';
require('includes/header.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  require('includes/database.php');

  $query = $conn->prepare("INSERT INTO users (username, email, password, type) VALUE (?, ?, ?, ?)");
  $query->bind_param('sssi', $_POST['username'], $_POST['email'], $_POST['password'], intval($_POST['type']));
  $query->execute();

  header('Location: login.php');

}



?>

<form method="POST">
  Username: <input type="username" name="username"><br>
  E-mail: <input type="email" name="email"><br>
  Password: <input type="password" name="password"><br>
  Repeat password: <input type="password" name="password-check"><br>
  Type: <input type="radio" name="type" value="1">User <input type="radio" name="type" value="0">Caretaker<br>
  <button type="submit">Register</button>
</form>

<?php
require('includes/footer.php');
?>
