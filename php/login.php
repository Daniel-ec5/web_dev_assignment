<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecs417";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $sql = "SELECT * FROM portfolio_admin WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $_SESSION["email"] = $email;
            $_SESSION["name"] = $result->fetch_assoc()["name"];
            $_SESSION["loggedIn"] = true;
            header("Location: addpost.php");
            exit();
        } else {
            $password = hash("sha256", $password);
            $sql = "SELECT * FROM portfolio_users WHERE email='$email' AND password='$password'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $_SESSION["email"] = $email;
                $_SESSION["name"] = $result->fetch_assoc()["firstName"];
                $_SESSION["loggedIn"] = true;
                header("Location: viewblog.php");
                exit();
            } else {
                echo "<script>alert('Invalid email or password');</script>";
                echo "<script>document.getElementById('form').reset</script>";
                echo "<script>window.location.href='login.php'</script>";

            }
        }
    }
    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daniel Ewelike's Blog</title>
    <link rel="stylesheet" href="../css/reset.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/header.css" />
    <link rel="stylesheet" href="../css/mobile.css" />

    <script src="../js/login.js" defer></script>

</head>

<body class="bg-dark text-light d-flex flex-column  justify-content-center align-items-center" id=login>
    <header>
        <nav>
            <li>
                <a href=" ../html/index.html" id="logo"><span style="color: crimson">D</span>aniel.EC</a>
            </li>
            <li><a href="../html/index.html">Home</a></li>
            <li><a href="viewblog.php">Blog</a></li>
            <li><a href="../html/about.html">About me</a></li>
            <li><a href="../html/skills.html">Skills and Experience</a></li>
            <li><a href="signup.php">Register</a></li>
        </nav>

        <li id="logo-list"><a href="index.html" id="logo1"><span style="color: crimson">D</span>aniel.EC</a></li>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-expanded="false">
                Menu</button>
            <ul class="dropdown-menu bg-dark" aria-labelledby="dropdownMenuButton">
                <li><a href="../html/index.html">Home</a></li>
                <li><a href="viewblog.php">Blog</a></li>
                <li><a href="../html/about.html">About me</a></li>
                <li><a href="../html/skills.html">Skills and Experience</a></li>
                <li><a href="signup.php">Register</a></li>
            </ul>
        </div>
    </header>
    <div class="card p-4 shadow login-form text-dark mt-5 w-45" id="login-form">
        <h2 class="text-center mt-3">Login</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="form">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="social d-flex justify-content-center gap-3 mt-4">
            <a href="https://www.linkedin.com/in/danielewelikechimezie"><img src="../images/ln.webp" alt="linkedin"
                    width="32" height="32"></a>
            <a href="https://github.com/Daniel-ec5"><img src="../images/github-128.webp" alt="github" width="32"
                    height="32"></a>
            <a href="mailto:Daniel.ec5@Outlook.com?subject=Portfolio%20Contact"><img src="../images/mail.webp"
                    alt="mail" width="32" height="32"></a>
            <a href="https://snapchat.com/add/daniel_el22"><img src="../images/spo.webp" alt="snapchat" width="32"
                    height="32"></a>
        </div>
    </div>

    <footer class="text-center mt-4">
        <p class="text-white">&copy; 2025 Daniel.EC</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>