<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["adminStatus"] == false) {
        header("location: ../user/index.php");
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title id="page-title"></title>
</head>

<body>

    <body class='bg-dark'>
        <header>
            <nav class="nav nav-pills navbar navbar-expand-lg navbar-dark bg-dark py-2">
                <div class="container-fluid">
                    <a class="navbar-brand" href="../">MyCinema Admin Panel</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="../">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../movie_list.php">Movie List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../movie_sessions_list.php">Movie Sessions</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../user_list.php">User List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../staff_list.php">Staff List</a>
                            </li>
                        </ul>
                    </div>
                    <form>
                        <a href="../logout.php" class="btn btn-danger ml-3">Sign Out</a>
                    </form>
                </div>
            </nav>
        </header>
        <div class="container-lg" id="container">
            <div class="row">
                <h1 class="text-center text-white p-5" id="profile-name"></h1>
            </div>
            <div class="card bg-secondary text-white">
                <nav class="nav navbar nav-tabs navbar-expand-lg navbar-dark bg-secondary card-header">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="./personal_information.php" id='navbar-brand-title'></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav nav-tabs navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active text-dark" aria-current="page" id='user-personal-information'>Personal Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id='user-subscriptions'>Subscriptions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="user-history">Movie History</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="card-header" id="user-profile">
                    <h3 class="text-center p-3">Personal Information</h3>
                    <div class='py-2'>
                        <h4 class="text-decoration-underline">E-mail :</h4>
                        <h5 id="user-email"></h5>
                    </div>
                    <div class='py-2'>
                        <h4 class="text-decoration-underline">Address :</h4>
                        <h5 id="user-address"></h5>
                    </div>
                    <div class='py-2'>
                        <h4 class="text-decoration-underline">Birthdate :</h4>
                        <h5 id="user-birthdate"></h5>
                    </div>

                </div>
                <div class="card-header" id="staff-info"></div>
    </body>
</body>
<script src="../scripts/user_profile/profile_load.js"></script>
<script src="../scripts/user_profile/personal_information/load.js"></script>
<script src="../scripts/user_profile/personal_information/staff_info_load.js"></script>

</html>