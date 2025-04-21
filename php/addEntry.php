<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecs417";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Could not connect to ecs417: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST["title"]);
    $content = $conn->real_escape_string($_POST["content"]);
    $sql = "INSERT INTO portfolio_post (title,content) VALUES ('$title','$content')";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Post added Successfully");</script>';
        header("Location:viewblog.php");
    } else {
        echo ('<script>alert("Post not added");</script>');
    }

}

$conn->close();
?>