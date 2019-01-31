<?php
$title = 'choose user';
require('includes/header.php');

if($_SESSION['loggedIn']){
  require('includes/database.php');

  $query = $conn->prepare("SELECT A.userid, U.email FROM association A LEFT JOIN users U ON A.userid = U.id  WHERE A.caretaker_userid = ?");
  $query->bind_param('i', $_SESSION['id']);
  $query->execute();
  $result = $query->get_result();

  if (count($result) == 0){
    echo "no users found";
  }
  while ($row = $result->fetch_array(MYSQLI_NUM)) {
    error_log(implode('\n', $row));

    ?>
    <form method="POST" action="<?php echo $_GET['rel']; ?>">
      <input type="hidden" name="id" value="<?php echo $row[0];?>">
      <button type="submit"><?php echo $row[1];?></button>
    </form>
    <?php
  }
}
else{
  ?>
  <span style="font-size:100;">You need to be logged in.
  <?php
}

require('includes/footer.php');
?>
