<?php
$title = 'Home';
require('includes/header.php');
?>

<div class="bubble">
    <h1>Welcome to APO</h1>
</div>

<?php
if($_SESSION['loggedIn']) {
    require("includes/database.php");

    $currentTime = date('H:i');

    $query = $conn->prepare("SELECT name, description, location, start_time, end_time FROM planning WHERE userid = ? AND date = ? AND invisible = 0 AND fixed = 1 AND TIME(start_time) <= TIME(?) AND TIME(end_time) > TIME(?) ORDER BY start_time, end_time LIMIT 1");
    $query->bind_param('isss', $userid, $date, $currentTime, $currentTime);
    $query->execute();

    $result = $query->get_result();

    if ($row = $result->fetch_array(MYSQLI_NUM)) {
        ?>
        <div class="bubble">
            <h2>Current event:</h2>
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
                    <?php echo $row[3]; ?></th>
                </tr>
                <tr>
                    <th>End time</th>
                    <td>
                    <?php echo $row[4]; ?></th>
                </tr>
            </table>
        </div>
        <?php
    }

    $query = $conn->prepare("SELECT name, description, location, start_time, end_time FROM planning WHERE userid = ? AND date = ? AND invisible = 0 AND fixed = 1 AND TIME(start_time) > TIME(?) ORDER BY start_time, end_time LIMIT 1");
    $query->bind_param('iss', $userid, $date, $currentTime);
    $query->execute();

    $result = $query->get_result();

    if ($row = $result->fetch_array(MYSQLI_NUM)) {
        ?>
        <div class="bubble">
            <h2>Next event:</h2>
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
                    <?php echo $row[3]; ?></th>
                </tr>
                <tr>
                    <th>End time</th>
                    <td>
                    <?php echo $row[4]; ?></th>
                </tr>
            </table>
        </div>
        <?php
    }
}
require('includes/footer.php');
?>
