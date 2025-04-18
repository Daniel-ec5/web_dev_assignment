<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecs417";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = htmlspecialchars($_POST["fname"]);
    $lname = htmlspecialchars($_POST["lname"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    if ($password != $cpassword) {
        echo "<script>alert('Passwords do not match!');</script>";
        echo "<script>window.location.href='signup.php';</script>";
        exit();
    }
    $password = hash("sha256", $password);
    $sql = "INSERT INTO portfolio_users (firstName,lastName,email,password) VALUES ('$fname','$lname','$email','$password')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Registration successful!');</script>";
        echo "<script>window.location.href='login.php';</script>";
        exit();

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <link rel="stylesheet" href="../css/reset.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/header.css" />
    <link rel="stylesheet" href="../css/mobile.css" />



</head>

<body class="bg-dark">
    <header class="bg-dark text-light">
        <nav>
            <li><a href="index.php" id="logo"><span style="color: crimson">D</span>aniel.EC</a></li>
            <li><a href="index.php">Home</a></li>
            <li><a href="viewblog.php">Blog</a></li>
            <li><a href="../html/about.html">About me</a></li>
            <li><a href="../html/skills.html">Skills and Experience</a></li>
            <li><a href="login.php">Sign In</a></li>
        </nav>

        <li id="logo-list"><a class="logo " href="index.html" id="logo1"><span
                    style="color: crimson">D</span>aniel.EC</a></li>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle " type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-expanded="false">
                Menu</button>
            <ul class="dropdown-menu bg-dark" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item text-light" href="index.php">Home</a></li>
                <li><a class="dropdown-item text-light" href="viewblog.php">Blog</a></li>
                <li><a class="dropdown-item text-light" href="../html/about.html">About me</a></li>
                <li><a class="dropdown-item text-light" href="../html/skills.html">Skills and Experience</a></li>
                <li><a class="dropdown-item text-light" href="login.php">Sign In</a></li>
            </ul>
        </div>
    </header>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 bg-light text-dark p-4 rounded shadow">
                <h2 class="text-center text-dark mb-4">User Registration Form</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="form">
                    <div class="mb-3">
                        <label for="fname" class="form-label" name="firstName">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First Name"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label" name="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last Name"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label" name="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter Email address" required </div>
                        <div class="mb-3">
                            <label for="password" class="form-label" name="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter Password" required />
                        </div>
                        <div class="mb-3">
                            <label for="cpassword" class="form-label" name="cpassword">Confirm Password</label>
                            <input type="password" class="form-control" id="cpassword" name="cpassword"
                                placeholder="Confirm Password" required />
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>