<?php
$title = 'Planning';
require('includes/header.php');

if($_SESSION['loggedIn']){

require('includes/database.php');

$date = date('Y-m-d');

$query = $conn->prepare("SELECT name, description, location, start_time, end_time FROM planning WHERE userid = ? AND date = ? ORDER BY start_time, end_time");
$query->bind_param('is', $_SESSION['id'], $date);
$query->execute();

$result = $query->get_result();

while ($row = $result->fetch_array(MYSQLI_NUM)) {
  error_log(implode('\n', $row));
?>


  <div class = "item">
<table>
  <tr>
    <th>Name</th>
    <td><?php echo $row[0];?></th>
  </tr>
  <tr>
    <th>Description</th>
    <td><?php echo $row[1];?></th>
  </tr>
  <tr>
    <th>Location</th>
    <td><?php echo $row[2];?></th>
  </tr>
  <tr>
    <th>Start time</th>
    <td><?php echo $row[3];?></th>
  </tr>
  <tr>
    <th>End time</th>
    <td><?php echo $row[4];?></th>
  </tr>
</table>
</div>
<?php
}
?>


<?php
}else{
  ?>
  <div class="item">
  <span>You need to be logged in.
  </div>
  <?php
}
require('includes/footer.php');
?>
