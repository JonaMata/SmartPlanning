<?php
$title = 'Login';
require('includes/header.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {

  require('includes/database.php');

  $query = $conn->prepare("SELECT id, password FROM users WHERE email = ? and password = ?");
  $query->bind_param('ss', $_POST['username'], $_POST['password']);
  $query->execute();
  $result = $query->get_result();
  if (!$result) {
        die("User not found");
  }
  if ($_POST['password'] !== $result['password']){
        die("Password does not match");
  }

  if ($row = $result->fetch_array(MYSQLI_NUM)) {
    $_SESSION['id']=$row['id'];
    $_SESSION['email']=$_POST['email'];
    $_SESSION['loggedIn']=true;
  }

  header("Location: index.php");
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
