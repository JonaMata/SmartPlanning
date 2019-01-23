<?php
$title = 'choose user';
require('includes/header.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {

  require('includes/database.php');

  $query = $conn->prepare("SELECT userid FROM association WHERE caretaker_userid = ?");
  $query->bind_param('i', $_SESSION['id']);
  $query->execute();
  $result = $query->get_result();

  while ($row = $result->fetch_array(MYSQLI_NUM)) {
    error_log(implode('\n', $row));
    ?>
    <form method="POST" action="planning.php">
      <input type="hidden" name="id" value="<?php echo $row[0];?>">
      <button type="submit"><?php echo $row[0];?></button>
    </form>
    <?php
  }

  else{
    die("No users found");
  }

  header("Location: index.php");
}


require('includes/footer.php');
?>
