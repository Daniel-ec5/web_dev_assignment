<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecs417";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
session_start();
if ($_SESSION["loggedIn"] == true && $_SESSION["email"] = "Daniel@admin") {
    if (isset($_GET["id"])) {
        $id = $conn->real_escape_string($_GET["id"]);
        $sql = "DELETE FROM portfolio_post WHERE ID='$id'";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Post deleted Successfully");</script>';
            header("Location:viewblog.php");
        } else {
            echo ('<script>alert("Post not deleted");</script>');
        }
    }
}
$conn->close();


?>