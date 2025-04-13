<?php 
session_start();
if(!isset($_SESSION["loggedIn"])){
    $_SESSION["loggedIn"]=false;
    $_SESSION["email"]="Guest";
    $_SESSION["firstName"]="Guest";
}
$servername="127.0.0.1";
$username="root";
$password="";
$dbname="ecs417";
//create connection
$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    die("Connection failed:".$conn->connect_error);
}
$sql="SELECT ID, title, content,time,zone FROM portfolio_post";
$result=$conn->query($sql);
if($result->num_rows > 0){
    $rows=$result->fetch_all(MYSQLI_ASSOC);
}
$sql="SELECT * FROM portfolio_admin WHERE ID=1";
$admin=$conn->query($sql);
if($admin->num_rows > 0){
    $admin=$admin->fetch_all(MYSQLI_ASSOC);
}

$admin=$admin[0];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daniel's Blog</title>
    <link rel="stylesheet" href="../css/reset.css" />
    <link rel="stylesheet" href="../css/index.css" />
    <link rel=stylesheet href=https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css>
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
            <?php if($_SESSION["loggedIn"]==True){
                echo "<li><a href=logout.php>Logout</a></li>";
            }else{
                echo "<li><a href=login.php>Sign In/Up</a></li>";

            } ?>
            </li>
        </nav>
    </header>
    <div class=container mt-5>
        <h1 class="display-4 text-dark">Daniel's Blog</h1>
        <?php if($_SESSION["loggedIn"]==true && $_SESSION["email"]=="Daniel@admin"){
            
            echo"<h4 class='display-6 text-dark'>Welcomes Admin</h4>";
            echo "<a href='../php/addpost.php' class='btn btn-primary'>Add post +</a>";
        }
        else if($_SESSION["loggedIn"]==true){
            echo "<h4 class='display-6 text-dark'>Welcomes ".$_SESSION["firstName"]."</h4>";
        }else{
            echo "<h4 class='display-6 text-dark'>Welcomes Guest</h4>";
        } ?>
        ?>
        <?php foreach($rows as $row): ?>
        <div class=card shadow-sm>
            <div class=card-body>
                <h3 class=card-title><?php echo($row["title"]); ?></h3>
                <h6 class=card-subtitle mb-2 text-muted>
                    By <strong><?php echo($admin["email"]); ?></strong> on
                    <?php $zone=new DateTimeZone($row["zone"]); $date=new Datetime($row["time"],$zone);  echo($date->format("jS F Y g:i A T")); ?>
                </h6>
                <br>
                <p class=card-text mt-3>
                    <?php echo($row["content"]); ?>
                </p>
                <?php if($_SESSION["loggedIn"]==true){
                    echo "<small><a href=comment.php>view comments</a></small>&nbsp;";
                } ?>

                <?php if($_SESSION["loggedIn"]==true && $_SESSION["email"]=="Daniel@admin"){
            echo "<small><a href=deletepost.php>Delete post</a>";
        }?>

                </small>
            </div>
        </div>

        <?php endforeach; $conn->close()?>

    </div>
    <footer class="bg-white text-dark py-4 mt-5">
        <div class="container text-center">
            <!-- Social Icons -->
            <div class="d-flex justify-content-center gap-4 mb-3">
                <a href="https://www.linkedin.com/in/danielewelikechimezie" class="mx-2" target="_blank">
                    <img src="../images/ln.webp" alt="LinkedIn" width="32" height="32">
                </a>
                <a href="https://github.com/Daniel-ec5" class="mx-2" target="_blank">
                    <img src="../images/github-128.webp" alt="GitHub" width="32" height="32">
                </a>
                <a href="mailto:Daniel.ec5@Outlook.com?subject=Portfolio%20Contact" class="mx-2">
                    <img src="../images/mail.webp" alt="Mail" width="32" height="32">
                </a>
                <a href="https://snapchat.com/add/daniel_el22" class="mx-2" target="_blank">
                    <img src="../images/spo.webp" alt="Snapchat" width="32" height="32">
                </a>
            </div>
            <!-- Footer Text -->
            <p class="mb-0 text-dark">&copy; 2025 Daniel Ewelike</p>
        </div>
    </footer>

    <script src=https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js></script>
</body>

</html>