<?php
$title = "Add Caretaker";
require "includes/header.php";


require "includes/database.php";

if(isset($_GET['email']) && isset($_GET['secret'])) {
    if(!$_SESSION['loggedIn']) {
        echo "You need to be logged in.";
    } else {
        if($_SESSION['type'] != "caretaker") {
            echo "You need to be a caretaker to take care of users";
        } else {

            echo "working";

            $query = $conn->prepare("INSERT INTO association (caretaker_userid, userid, timeslots) VALUE (?, (SELECT id FROM users WHERE email=? AND secret=?), '')");
            $query->bind_param('iss', $_SESSION['id'], $_GET['email'], $_GET['secret']);
            $query->execute();

            echo $query->error;
        }
    }


} else if($_SESSION['loggedIn'] && $_SESSION['type'] == "user") {

    $secret = md5(uniqid($_SESSION['email'], true));

    $query = $conn->prepare("UPDATE users SET secret=? WHERE id=?");
    $query->bind_param('si', $secret, $_SESSION['id']);
    $query->execute();

    echo $query->error;

    $link = "https://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]."?email=".$_SESSION['email']."&secret=".$secret

    ?>
    <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo urlencode($link); ?>"/>
    <br>
    <input type="text" value="<?php echo $link; ?>" id="link">
    <button onclick="copyLink()">Copy link</button>

    <script>
        function copyLink() {
            var link = document.getElementById("link");
            link.select();
            document.execCommand("copy");
        }
    </script>

    <?php
}

require "includes/footer.php";
?>