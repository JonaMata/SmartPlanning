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

<script src="/register_check.js"></script>

<form method="POST">
  Name: <input type="text" name="name" maxlength="100"><br>
  E-mail: <input type="email" name="email" maxlength="100" required><br>
  Password: <input type="password" id="password" name="password" maxlength="100" onkeyup="check();" required><br>
  Repeat password: <input type="password" id="password-check" name="password-check" maxlength="100" onkeyup="check();" required><br>
  Type: <input type="radio" name="type" value="1" checked>User <input type="radio" name="type" value="0">Caretaker<br>
  <span id='message'></span><br>
  <button type="submit" id="btnSubmit">Register</button>
</form>

<?php
require('includes/footer.php');
?>
