<?php
$title = "Settings";
require "includes/header.php";

if(!$_SESSION['loggedIn']) die("You need to be logged in.");

require "includes/database.php";


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateQuery = $conn->prepare("UPDATE association SET category = ? WHERE userid = {$_SESSION['id']} AND caretaker_userid = ?");
    foreach($_POST as $key=>$value) {
        echo "{$key}->{$value}";
        $updateQuery->bind_param('si', $value, $key);
        $updateQuery->execute();
    }
}






$query = $conn->prepare("SELECT U.email, A.category, U.id FROM users U LEFT JOIN association A ON U.id = A.caretaker_userid WHERE A.userid = ?");
$query->bind_param('i', $_SESSION['id']);
$query->execute();
$result = $query->get_result();

?>
<h1>Settings</h1>
<hr>
<h2>Caretakers</h2>
<hr>
<form>
    <table>
        <tr>
            <th>Caretaker</th>
            <th>Category</th>
        </tr>
        <?php
        while($row = $result->fetch_array(MYSQLI_NUM)) {
            echo $row[1];
            $category = (($row[1] == "none" || $row[1] == "") ? "none" : $row[1]);
            ?>
            <tr>
                <td><?php echo $row[0]; ?></td>
                <td>
                    <select name="<?php echo $row[2]; ?>">
                        <option value="none" <?php echo ($category == "none" ? "selected" : ""); ?>>None</option>
                        <option value="home" <?php echo ($category == "home" ? "selected" : ""); ?>>Home</option>
                        <option value="school" <?php echo ($category == "school" ? "selected" : ""); ?>>School</option>
                        <option value="work" <?php echo ($category == "work" ? "selected" : ""); ?>>Work</option>
                        <option value="other" <?php echo ($category == "other" ? "selected" : ""); ?>>Other</option>
                    </select>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <button type="submit">Update caretakers</button>
</form>



<?php


require "includes/footer.php";
?>