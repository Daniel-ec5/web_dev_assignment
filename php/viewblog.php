<?php
session_start();
if (!isset($_SESSION["loggedIn"])) {
    $_SESSION["loggedIn"] = false;
    $_SESSION["email"] = "Guest";
    $_SESSION["firstName"] = "Guest";
}
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecs417";
//create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
//if sort is not set, do default getting
$month = 0;
$desc = 0;
if (!isset($_GET["sort"])) {
    $month = 0;
} else {
    if ($_GET["sort"] == "1") {
        $month = 1;
    } else if ($_GET["sort"] == "2") {
        $month = "2";
    } else if ($_GET["sort"] == "3") {
        $month = "3";
    } else if ($_GET["sort"] == "4") {
        $month = "4";
    } else if ($_GET["sort"] == "5") {
        $month = "5";
    } else if ($_GET["sort"] == "6") {
        $month = "6";
    } else if ($_GET["sort"] == "7") {
        $month = "7";
    } else if ($_GET["sort"] == "8") {
        $month = "8";
    } else if ($_GET["sort"] == "9") {
        $month = "9";
    } else if ($_GET["sort"] == "10") {
        $month = "10";
    } else if ($_GET["sort"] == "11") {
        $month = "11";
    } else if ($_GET["sort"] == "12") {
        $month = "12";
    } else if ($_GET["sort"] == "-1") {
        $desc = -1;
    }
}
if ($month === 0) {
    $sql = "SELECT ID, title, content, time, zone FROM portfolio_post";

} else if ($desc === -1) {
    $sql = "SELECT ID, title, content, time, zone FROM portfolio_post ORDER BY ID ASC";
} else {
    $sql = "SELECT ID, title, content, time, zone FROM portfolio_post WHERE MONTH(time) = $month";
}
//whatever was gotten as the query code will be passed here
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $initialArray = $result->fetch_all(MYSQLI_ASSOC);
    $invalid = false;
} else {

    $invalid = true;

}
//selection sort
//1. the outer loop iterates through the array, treating each element as the current maximum
//2. the inner loop iterates through the unsorted portion of the array to find the maximum element
//if a larger element is found, the index of the maximum element is updated
//3. after the inner loop, if the maximum element is not already in the correct position, it is swapped with the current index
//4. this process continues until the entire array is sorted in descending order
//5. the function returns the sorted array
//instead of using in values, im using the time of each post as a value converted by strtotime for easier comparison
function selectionSortByDate(array $posts): array
{
    $n = count($posts);

    for ($i = 0; $i < $n - 1; $i++) {
        $maxIdx = $i;

        for ($j = $i + 1; $j < $n; $j++) {
            if (strtotime($posts[$j]['time']) > strtotime($posts[$maxIdx]['time'])) {
                $maxIdx = $j;
            }
        }
        // Swap the found maximum with current index
        if ($maxIdx !== $i) {
            $temp = $posts[$i];
            $posts[$i] = $posts[$maxIdx];
            $posts[$maxIdx] = $temp;
        }
    }
    return $posts;
}
//pass the posts to be sorted if only the sort was set to a value not -1 i.e not oldest
if ($desc == -1) {
    $rows = $initialArray;
} elseif (!$invalid) {
    //sort the posts by date using selection sort
    $rows = selectionSortByDate($initialArray);
}
$sql = "SELECT * FROM portfolio_admin WHERE ID=1";
$admin = $conn->query($sql);
if ($admin->num_rows > 0) {
    $admin = $admin->fetch_all(MYSQLI_ASSOC);
    $_SESSION["admin"] = $admin[0]["name"];
}

$admin = $admin[0];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daniel's Blog</title>
    <link rel="stylesheet" href="../css/reset.css" />
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/mobile.css" />
    <script src="../js/delete.js" defer></script>
    <script src="../js/sort.js" defer></script>

</head>

<body id="view" style="background-color: black;">
    <header>
        <nav>
            <li><a href="index.html" id="logo"><span style="color: crimson">D</span>aniel.EC</a></li>
            <li>
            <li><a href="../html/index.html">Home</a></li>
            <li><a href="../php/viewblog.php">Blog</a></li>
            <li><a href="../html/about.html">About me</a></li>
            <li><a href="../html/skills.html">Skills and Experience</a></li>
            <?php if ($_SESSION["loggedIn"] == True) {
                echo "<li><a href=logout.php>Logout</a></li>";
            } else {
                echo "<li><a href=login.php>Sign In/Up</a></li>";

            } ?>
            </li>
        </nav>

        <li id="logo-list"><a href="index.html" id="logo1"><span style="color: crimson">D</span>aniel.EC</a></li>
        <div class="dropdown">
            <button class="btn bg-dark btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-expanded="false">
                Menu</button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item " href='index.php'>Home</a></li>
                <li><a class="dropdown-item" href='viewblog.php'>Blog</a></li>
                <li><a class="dropdown-item" href='../html/about.html'>About me</a></li>
                <li>
                    <a class="dropdown-item" href='../html/skills.html'>Skills and Experience</a>
                </li>
                <?php if ($_SESSION["loggedIn"] == True) {
                    echo "<li><a class='dropdown-item' href=logout.php>Logout</a></li>";
                } else {
                    echo "<li><a class='dropdown-item' href=login.php>Sign In/Up</a></li>";

                } ?>
                </li>
            </ul>
        </div>
    </header>
    <div class="container bootstrap-container mt-5">
        <h1 class="display-4 text-white">Daniel's Blog</h1>
        <?php if ($_SESSION["loggedIn"] == true && $_SESSION["email"] == "Daniel@admin") {

            echo "<h4 class='display-6 text-white'>Welcomes Admin</h4>";
            echo "<a href='../php/addpost.php' class='btn btn-primary'>Add post +</a>";
        } else if ($_SESSION["loggedIn"] == true) {
            echo "<h4 class='display-6 text-white'>Welcomes " . $_SESSION["name"] . "</h4>";
        } else {
            echo "<h4 class='display-6 text-white'>Welcomes Guest</h4>";
        } ?>

        <div class="sort-container">
            <label for="sort">Sort By:</label>
            <select id="sort" name="sort">
                <option value="check">
                    <?php if ($month == 0 && $desc == 0) {
                        echo "Most recent";
                    } else if ($month == 1)
                        echo "January";
                    else if ($month == 2)
                        echo "February";
                    else if ($month == 3)
                        echo "March";
                    else if ($month == 4)
                        echo "April";
                    else if ($month == 5)
                        echo "May";
                    else if ($month == 6)
                        echo "June";
                    else if ($month == 7)
                        echo "July";
                    else if ($month == 8)
                        echo "August";
                    else if ($month == 9)
                        echo "September";
                    else if ($month == 10)
                        echo "October";
                    else if ($month == 11)
                        echo "November";
                    else if ($month == 12)
                        echo "December";
                    else if ($desc == -1)
                        echo "Oldest";
                    ?>
                </option>
                <option value="0">Most Recent</option>
                <option value="-1">Oldest</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
        </div>
        <?php if ($invalid): ?>
            <div class="alert alert-danger" role="alert">
                No posts available for the selected month.
            </div>

        <?php else: ?>

            <?php foreach ($rows as $row): ?>
                <div class="card w-100 my-4" style="max-width: 720px; margin-left: auto; margin-right: auto;">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo htmlspecialchars($row["title"]); ?></h3>
                        <h6 class="card-subtitle mb-2 text-muted">
                            By <strong><?php echo htmlspecialchars($admin["name"]); ?></strong> on
                            <?php
                            $zone = new DateTimeZone($row["zone"]);
                            $date = new DateTime($row["time"], $zone);
                            echo $date->format("jS F Y g:i A T");
                            ?>
                        </h6>
                        <p class="card-text mt-3"><?php echo htmlspecialchars($row["content"]); ?></p>
                        <?php if ($_SESSION["loggedIn"]): ?>
                            <small><a href="comment.php?id=<?php echo $row["ID"]; ?>">Comments</a></small>&nbsp;
                        <?php endif; ?>
                        <?php if ($_SESSION["loggedIn"] && $_SESSION["email"] === "Daniel@admin"): ?>
                            <small><a class="postdel text-danger" href="deletepost.php?id=<?php echo $row["ID"]; ?>">Delete
                                    post</a></small>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php $conn->close(); ?>
    </div>

    <footer class="bg-white text-dark py-4 mt-5">
        <div class="container text-center">
            <!-- Social Icons -->
            <div class="d-flex justify-content-center gap-4 mb-3">
                <a href="https://www.linkedin.com/in/danielewelikechimezie" class="img-fluid social-icon"
                    target="_blank">
                    <img src="../images/ln.webp" alt="LinkedIn" width="32" height="32">
                </a>
                <a href="https://github.com/Daniel-ec5" class="img-fluid social-icon" target="_blank">
                    <img src="../images/github-128.webp" alt="GitHub" width="32" height="32">
                </a>
                <a href="mailto:Daniel.ec5@Outlook.com?subject=Portfolio%20Contact" class="img-fluid social-icon">
                    <img src="../images/mail.webp" alt="Mail" width="32" height="32">
                </a>
                <a href="https://snapchat.com/add/daniel_el22" class="img-fluid social-icon" target="_blank">
                    <img src="../images/spo.webp" alt="Snapchat" width="32" height="32">
                </a>
            </div>
            <!-- Footer Text -->
            <p class="mb-0 text-dark">&copy; 2025 Daniel Ewelike</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>