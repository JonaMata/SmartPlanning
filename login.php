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
  }

  header("Location: index.php");
}
?>
<div class="bubble">
<form method="POST">
  E-mail: <input type="email" name="email" required><br>
  Password: <input type="password" name="password" required><br>
  <button style="width: 200px; height: 20px"type="submit">Login</button>
</form>
</div>

<?php
require('includes/footer.php');
?>
