<?php
$title = 'Planning';
require('includes/header.php');

if ($_SESSION['loggedIn']) {

    require('includes/database.php');

    if (isset($_POST['date'])) {
        $date = $_POST['date'];
    } else {
        $date = date('Y-m-d');
    }

    if (isset($_POST['id'])) {
        $userid = $_POST['id'];
    } else {
        $userid = $_SESSION['id'];
    }

    require("includes/processPlanning.php");

    ?>

    <form method='POST'>
        Date:
        <input type="date" name="date">
        <input type="hidden" name="id" value="<?php echo($userid) ?>">
        <input type="submit" value="go">
    </form>
    <h2>Planning</h2>
    <?php
    $query = $conn->prepare("SELECT name, description, location, start_time, end_time FROM planning WHERE userid = ? AND date = ? AND invisible = 0 AND fixed = 1 ORDER BY start_time, end_time");
    $query->bind_param('is', $userid, $date);
    $query->execute();

    $result = $query->get_result();

    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        error_log(implode('\n', $row));
        ?>
        <div class="bubble">
            <table>
                <tr>
                    <th>Name</th>
                    <td>
                    <?php echo $row[0]; ?></th>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>
                    <?php echo $row[1]; ?></th>
                </tr>
                <tr>
                    <th>Location</th>
                    <td>
                    <?php echo $row[2]; ?></th>
                </tr>
                <tr>
                    <th>Start time</th>
                    <td>
                    <?php echo date('H:i', strtotime($row[3])); ?></th>
                </tr>
                <tr>
                    <th>End time</th>
                    <td>
                    <?php echo date('H:i', strtotime($row[4])); ?></th>
                </tr>
            </table>
        </div>
        <?php
    }
    ?>
    <h2>Unfixed events</h2>

    <?php


    $query = $conn->prepare("SELECT name, description, location, start_time, end_time FROM planning WHERE userid = ? AND date = ? AND invisible = 0 AND fixed = 0) ORDER BY start_time, end_time");
    $query->bind_param('is', $userid, $date);
    $query->execute();

    $result = $query->get_result();

    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        error_log(implode('\n', $row));
        ?>
        <div class="bubble">
            <table>
                <tr>
                    <th>Name</th>
                    <td>
                    <?php echo $row[0]; ?></th>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>
                    <?php echo $row[1]; ?></th>
                </tr>
                <tr>
                    <th>Location</th>
                    <td>
                    <?php echo $row[2]; ?></th>
                </tr>
                <tr>
                    <th>Duration</th>
                    <td>
                    <?php echo round(abs(strtotime($row[4])-strtotime($row[3]))/60,2); ?></th>
                </tr>
            </table>
        </div>
        <?php
    }

} else {
    ?>
    <div class="bubble">
  <span>You need to be logged in.
    </div>
    <?php
}
require('includes/footer.php');
?>
