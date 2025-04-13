<?php 
$servername="127.0.0.1";
$username="root";
$password="";
$dbname="ecs417";
$conn=new mysqli($servername,$username,$password,$dbname);

if ($conn->connect_error) {
    die("Could not connect to ecs417: " . $conn->connect_error);
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $title=$conn->real_escape_string($_POST["title"]);
    $content=$conn->real_escape_string($_POST["content"]);
    $sql="INSERT INTO portfolio_post (title,content) VALUES ('$title','$content')";
    if($conn->query($sql)===TRUE){
        echo '<script>alert("Post added Successfully");</script>';
         header("Location:viewblog.php");
    }
    else{
        echo('<script>alert("Post not added");</script>');
    }

}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add blog</title>
    <link rel="stylesheet" href="../css/reset.css" />
    <link rel="stylesheet" href="../css/index.css" />
    <script src="../js/addblog.js" defer></script>
</head>

<body id="addblog">
    <header>
        <nav>
            <li><a href="index.php" id="logo"><span style="color: crimson">D</span>aniel.EC</a></li>
            <li><a href="index.php">Home</a></li>
            <li><a href="viewblog.php">Blog</a></li>
            <li><a href="../html/about.html">About me</a></li>
            <li><a href="../html/skills.html">Skills and Experience</a></li>
        </nav>
    </header>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h2>Add Blog</h2>
        <fieldset class="main">
            <section>
                <label for="title">Enter Title</label>
                <br />
                <input type="text" placeholder="Title" id="title" name="title" />
                <br />
            </section>
            <section>
                <label for="content">Enter Content</label>
                <br />
                <textarea name="content" id="content" cols="30" rows="6" placeholder="Content"></textarea>
            </section>
            <section class="button">
                <button type="submit" id="post">Add Blog</button>
                <button type="button" id="clearpost">Clear</button>
            </section>
    </form>
    <footer>
        <p>&copy; 2025 Daniel.EC</p>
    </footer>
</body>

</html>