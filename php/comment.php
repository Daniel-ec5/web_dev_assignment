<?php
session_start();

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecs417";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
//check if post was clicked i.e postid was passed to it, if not redirect to viewblog.php
if (isset($_GET["id"])) {
    $id = $conn->real_escape_string($_GET["id"]);
    $sql = "SELECT *  FROM portfolio_post WHERE ID='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    }

    //reads all comments from db for the particular post
    $sql = "SELECT * FROM portfolio_comment WHERE postID='$id' ORDER BY date DESC";
    $result2 = $conn->query($sql);
    if ($result2->num_rows > 0) {
        $rows = $result2->fetch_all(MYSQLI_ASSOC);
        $noComments = false;
    } else {
        $noComments = true;
    }
    //posts the comment to the db
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $comment = htmlspecialchars($_POST["comment"]);
        $postID = htmlspecialchars($_GET["id"]);
        $firstName = $_SESSION["name"];
        $sql = "INSERT INTO portfolio_comment (postID, username,content) VALUES ( '$postID', '$firstName', '$comment')";
        if ($conn->query($sql) === TRUE) {
            echo '<script>  alert("Comment posted successfully");</script>';
            echo '<script>window.location.href="comment.php?id=' . $postID . '"</script>';
        } else {
            echo '<script>  alert("Error posting comment");</script>';
            echo '<script>window.location.href="comment.php?id=' . $postID . '"</script>';
        }
    }
} else {
    echo '<script>  alert("A post was not selected");</script>';
    echo '<script>window.location.href="viewblog.php"</script>';
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link rel="stylesheet" href="../css/reset.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel=" stylesheet" href="../css/header.css" />
    <link rel="stylesheet" href="../css/mobile.css" />
    <script src="../js/delete.js" defer></script>
</head>

<body>

    <header>
        <nav>
            <li><a href="index.html" id="logo"><span style="color: crimson">D</span>aniel.EC</a></li>
            <li>
            <li><a href="../html/index.html">Home</a></li>
            <li><a href="../php/viewblog.php">Blog</a></li>
            <li><a href="../html/about.html">About me</a></li>
            <li><a href="../html/skills.html">Skills and Experience</a></li>
            <li><a href=logout.php>Logout</a></li>

            </li>
        </nav>
        <li id="logo-list"><a class="text-dark" href="index.html" id="logo2"><span
                    style="color: crimson">D</span>aniel.EC</a></li>
        <div class="dropdown">
            <button class="btn bg-dark btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-expanded="false">
                Menu</button>
            <ul class="dropdown-menu bg-dark" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item text-white" href='index.php'>Home</a></li>
                <li><a class="dropdown-item text-white" href='viewblog.php'>Blog</a></li>
                <li><a class="dropdown-item text-white" href='../html/about.html' 1?>About me</a></li>
                <li>
                    <a class="dropdown-item text-white" href='../html/skills.html'>Skills and Experience</a>
                </li>
                <?php if ($_SESSION["loggedIn"] == True) {
                    echo "<li><a class='dropdown-item text-white' href=logout.php>Logout</a></li>";
                } else {
                    echo "<li><a class='dropdown-item text-white' href=login.php>Sign In/Up</a></li>";
                } ?>
                </li>
            </ul>
        </div>
    </header>
    <!-- <?php echo $firstName ?> -->
    <!-- //display the post -->
    <div class=card shadow-sm>
        <div class="card-body mb-3">
            <h3 class=card-title><?php echo ($post["title"]); ?></h3>
            <h6 class=card-subtitle mb-2 text-muted>
                By <strong><?php echo ($_SESSION["admin"]); ?></strong> on
                <?php $zone = new DateTimeZone($post["zone"]);
                $date = new Datetime($post["time"], $zone);
                echo ($date->format("jS F Y g:i A T")); ?>
            </h6>
            <br>
            <p class=card-text mt-3>
                <?php echo ($post["content"]); ?>
            </p>
        </div>
    </div>
    <hr>
    <h4 class="display-6 text-dark">Comments</h4>
    <hr>
    <!-- //comments form, single line with bootstrap -->
    <!-- the url encode adds the previous post id that was used to display the post , this is added to the post of the comment so that the else statement is not run -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . urlencode($_GET['id']); ?>"
        method="POST">
        <div class="d-flex justify-content-center mt-4 w-100">
            <input type="text" id="comment" name="comment" class="form-control w-50 me-2"
                placeholder="Add a comment...">
            <input type="submit" class="btn btn-primary" value="Post">
        </div>
    </form>
    <?php if ($noComments === true) {
        echo '<h6 class="mt-3 text-dark">No Comments</h6>';
    } ?>
    <!-- 
//display all comments -->
    <?php foreach ($rows as $row): ?>
    <div class=card shadow-sm>
        <div class=card-body>
            <h6 class=card-subtitle mb-3 text-muted>
                By <strong> <?php echo ($row["username"]); ?> </strong> on <?php echo ($row["date"]); ?>
            </h6>
            <br>
            <p class=card-text mt-3>
                <?php echo ($row["content"]); ?>
            </p>
            <?php if ($_SESSION["loggedIn"] == true && $_SESSION["email"] == "Daniel@admin") {
                    echo "<a class=commentdel style='color:red' href=deleteComment.php?id=" . $row["ID"] . ">Delete</a> </>";
                } ?>
        </div>
    </div>
    <hr>
    <?php endforeach; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>