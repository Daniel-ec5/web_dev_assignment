<?php
session_start();

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecs417";
//create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
$sql = "SELECT * FROM portfolio_comment WHERE ID='" . $_GET["id"] . "'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $postID = $rows[0]["postID"];
}
$sql = "DELETE FROM portfolio_comment WHERE ID='" . $_GET["id"] . "'";
if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Comment deleted successfully");</script>';
    echo '<script>window.location.href="comment.php?id=' . $postID . '"</script>';
} else {
    echo '<script>alert("Error deleting comment");</script>';
    echo '<script>window.location.href="comment.php?id=' . $postID . '"</script>';
}

?>