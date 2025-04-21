<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Post</title>
    <link rel="stylesheet" href="../css/reset.css" />
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="../css/mobile.css" />
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
            <li><a href="logout.php">logout</a></li>
        </nav>
        <li id="logo-list"><a href="index.php" id="logo1"><span style="color: crimson">D</span>aniel.EC</a></li>
    </header>
    <form action="addEntry.php" method="POST">
        <h2>Add New Post</h2>
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