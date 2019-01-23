<?php
$title = "Settings";
require "includes/header.php";

if(!$_SESSION['loggedIn']) die("You need to be logged in.");

require "includes/database.php";

$query = $conn->prepare("SELECT U.email, A.category FROM users U LEFT JOIN association A ON U.userid = A.caretaker_userid WHERE A.userid = ?");
echo $query->error;
$query->bind_param('i', $_SESSION['id']);
$query->execute();
$result = $query->get_result();


if ($row = $result->fetch_array(MYSQLI_NUM)) {
    $_SESSION['id']=$row[0];
    $_SESSION['email']=$_POST['email'];
    $_SESSION['type']=($row[1] == 1 ? "user" : "caretaker");
    $_SESSION['loggedIn']=true;
}

?>
<h1>Settings</h1>
<hr>
<br>
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
            ?>
            <tr>
                <td><?php echo $row[0]; ?></td>
                <td>
                    <select name="<?php echo "caretaker".$row[0]; ?>">
                        <option value="home" <?php echo ($row[1] == "home" ? "selected" : ""); ?>>Home</option>
                        <option value="school" <?php echo ($row[1] == "school" ? "selected" : ""); ?>>School</option>
                        <option value="work" <?php echo ($row[1] == "work" ? "selected" : ""); ?>>Work</option>
                        <option value="other" <?php echo ($row[1] == "other" ? "selected" : ""); ?>>Other</option>
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