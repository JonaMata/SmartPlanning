<?php
$title = 'Register';
require('includes/header.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  require('includes/database.php');

  $query = $conn->prepare("INSERT INTO users (email, password, type) VALUE (?, ?, ?)");
  $query->bind_param('ssi', $_POST['email'], $_POST['password'], intval($_POST['type']));
  $query->execute();

  header('Location: login.php');

}

?>

<script src="register_check.js"></script>

<div class="bubble">
<form method="POST">
    <table>
        <tr><td>E-mail:</td><td><input type="email" name="email" maxlength="100" required></td></tr>
        <tr><td>Password:</td><td><input type="password" id="password" name="password" maxlength="100" onkeyup="check();" required></td></tr>
        <tr><td>Repeat password:</td><td><input type="password" id="password-check" name="password-check" maxlength="100" onkeyup="check();" required></td></tr>
        <tr><td></td><td><span id='message'></span></td></tr>
        <tr><td>Type:</td><td><input type="radio" name="type" value="1" checked>User <input type="radio" name="type" value="0">Caretaker</td></tr>
        <tr><td colspan="2"><button type="submit" id="btnSubmit">Register</button></td></tr>
    </table>
</form>
</div>

<?php
require('includes/footer.php');
?>
