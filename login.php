<?php
$title = 'Login';
require('includes/header.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {

  require('includes/database.php');

  $query = $conn->prepare("SELECT id, type FROM users WHERE email = ? and password = ?");
  $query->bind_param('ss', $_POST['email'], $_POST['password']);
  $query->execute();
  $result = $query->get_result();
  if (!$result) {
        die("Email or password incorrect.");
  }

  if ($row = $result->fetch_array(MYSQLI_NUM)) {
    $_SESSION['id']=$row[0];
    $_SESSION['email']=$_POST['email'];
    $_SESSION['type']=($row[1] == 1 ? "user" : "caretaker");
    $_SESSION['loggedIn']=true;
  } else {
    die("Email or password incorrect.");
  }

  header("Location: index.php");
}
?>
<div class="bubble">
<form method="POST">
    <table>
        <tr><td>E-mail:</td><td><input type="email" name="email" required></td></tr>
        <tr><td>Password:</td><td><input type="password" name="password" required></td></tr>
        <tr><td colspan="2"><button type="submit">Login</button></td></tr>
    </table>
</form>
</div>

<?php
require('includes/footer.php');
?>
