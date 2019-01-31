<?php
$title = 'Add event';
require('includes/header.php');

if ($_SESSION['loggedIn']) {

    $userid = $_SESSION['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['id'])) {
            $userid = $_POST['id'];
        } else {
            require('includes/database.php');

            $query = $conn->prepare("INSERT INTO planning (userid, name, description, location, date, start_time, end_time, fixed, priority, can_next_day, due_date) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $query->bind_param('issssssiiis', $userid, $_POST['name'], $_POST['description'], $_POST['location'], $_POST['date'], $_POST['start_time'], $_POST['end_time'], intval($_POST['fixed']), intval($_POST['priority']), intval($_POST['can_next_day']), $_POST['due_date']);
            $query->execute();

            header('Location: planning.php');
        }
    }


    ?>
    <div class="bubble">
        <form method="POST">
            <input type="hidden" name="userid" value="<?php echo $userid; ?>">
            <table>
                <tr>
                    <td>Event</td>
                    <td><input name="name"></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><input name="description"></td>
                </tr>
                <tr>
                    <td>Location</td>
                    <td><input name="location"></td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td><input type="date" name="date"></td>
                </tr>
                <tr>
                    <td>Start time</td>
                    <td><input type="time" name="start_time"></td>
                </tr>
                <tr>
                    <td>End time</td>
                    <td><input type="time" name="end_time"></td>
                </tr>
                <tr>
                    <td>Fixed</td>
                    <td><input type="checkbox" value="1" name="fixed"></td>
                </tr>
                <tr>
                    <td>Priority</td>
                    <td><input type="number" name="priority"></td>
                </tr>
                <tr>
                    <td>Can next day</td>
                    <td><input type="checkbox" value="1" name="can_next_day"></td>
                </tr>
                <tr>
                    <td>Due date</td>
                    <td><input type="date" name="due_date"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">Add event</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <?php
} else {
    ?>
    <div class="bubble">
  <span>You need to be logged in.
    </div>
    <?php
}
require('includes/footer.php');
?>
