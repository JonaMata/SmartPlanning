<?php
$title = 'Add event';
require('includes/header.php');

if($_SESSION['loggedIn']){

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  require('includes/database.php');

  $query = $conn->prepare("INSERT INTO planning (userid, name, description, location, date, start_time, end_time, fixed, priority, can_next_day, due_date) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $query->bind_param('issssssiiis', $_SESSION['id'], $_POST['name'], $_POST['description'], $_POST['location'], $_POST['date'], $_POST['start_time'], $_POST['end_time'], intval($_POST['fixed']), intval($_POST['priority']), intval($_POST['can_next_day']), $_POST['due_date']);
  $query->execute();

  header('Location: planning.php');

}



?>
<div class="bubble">
<form method="POST">
  Event <input name="name"><br>
  Description <input name="description"><br>
  Location <input name="location"><br>
  Date <input type="date" name="date"><br>
  Start time <input type="time" name="start_time"><br>
  End time <input type="time" name="end_time"><br>
  Fixed <input type="checkbox" value="1" name="fixed"><br>
  Priority <input type="number" name="priority"><br>
  Can be moved to next day <input type="checkbox" value="1" name="can_next_day"><br>
  Due date <input type="date" name="due_date"><br>
  <button style="height 200px; width:200px" type="submit">Add event</button>
</form>
</div>

<?php
}else{
  ?>
  <div class="bubble">
  <span>You need to be logged in.
  </div>
  <?php
}
require('includes/footer.php');
?>
