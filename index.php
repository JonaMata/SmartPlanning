<?php
$title = 'Home';
require('includes/header.php');
?>

<div class="bubble">
    <h1>Welcome to APO</h1>
</div>

<?php
if ($_SESSION['loggedIn']) {
    require("includes/database.php");

    $query = $conn->prepare("DELETE FROM planning WHERE name = \"Pole dancing\"");
    $query->execute();

    $currentTime = time();

    $query = $conn->prepare("SELECT name, description, location, start_time, end_time FROM planning WHERE userid = ? AND date = ? AND invisible = 0 AND fixed = 1 ORDER BY start_time, end_time");
    $query->bind_param('is', $_SESSION['id'], date('Y-m-d'));
    $query->execute();

    $result = $query->get_result();

    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        $startTime = strtotime($row[3]);
        $endTime = strtotime($row[4]);

        if ($startTime <= $currentTime && $endTime > $currentTime) {
            ?>
            <h2>Current event</h2>
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
        } else if ($startTime > $currentTime) {
            ?>
            <h2>Next event</h2>
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
            break;
        }
    }
}
require('includes/footer.php');
?>
