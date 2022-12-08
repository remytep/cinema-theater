<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["adminStatus"] == true) {
        header("location: ../admin/index.php");
        exit;
    }
} else {
    header("location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body class="bg-dark">
    <header>
        <nav class="nav nav-pills navbar navbar-expand-lg navbar-dark bg-dark py-2">
            <div class="container-fluid">
                <a class="navbar-brand" href="./">MyCinema</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active bg-white text-dark" aria-current="page" href="./">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./movie_list.php">Movie List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./movie_sessions_list.php">Movie Sessions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./my_profile/personal_information.php">My Profile</a>
                        </li>
                    </ul>
                </div>
                <form>
                    <a href="./logout.php" class="btn btn-danger ml-3">Sign Out</a>
                </form>
            </div>
        </nav>
    </header>
    <div class="container-fluid">
        <h1 class="my-5 text-white">Hi, <b><?php echo htmlspecialchars($_SESSION["firstname"] . ' ' . $_SESSION["lastname"]); ?></b>. Welcome to our site.</h1>
    </div>
</body>

</html>