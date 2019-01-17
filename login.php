<?php
$title = 'Login';
require('includes/header.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {

  require('includes/database.php');

  $query = $conn->prepare("SELECT id FROM users WHERE username = ? and password = ?");
  $query->bind_param('ss', $_POST['username'], $_POST['password']);
  $query->execute();
  $result = $query->get_result();
  if ($row = $result->fetch_array(MYSQLI_NUM)) {
    $_SESSION['id']=$row[0];
    $_SESSION['username']=$_POST['username'];
    $_SESSION['loggedIn']=true;
  }

  header("Location: /");
}
?>

<form method="POST">
  Username: <input name="username"><br>
  Password: <input type="password" name="password"><br>
  <button type="submit">Login</button>
</form>

<?php
require('includes/footer.php');
?>
