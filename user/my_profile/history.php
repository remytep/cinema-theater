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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title id="page-title"></title>
</head>

<body class='bg-dark'>
    <header>
        <nav class="nav nav-pills navbar navbar-expand-lg navbar-dark bg-dark py-2">
            <div class="container-fluid">
                <a class="navbar-brand" href="../">MyCinema</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="../">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="..movie_list.php">Movie List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../movie_sessions_list.php">Movie Sessions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../my_profile/personal_information.php">My Profile</a>
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
                    <a class="navbar-brand" id='navbar-brand-title'></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav nav-tabs navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" id='user-personal-information'>Personal Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id='user-subscriptions'>Subscriptions</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active text-dark" id="user-history">Movie History</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="card-body bg-secondary">
                <form class='row g-0 text-white'>
                    <div class="col-auto py-2 px-4 ps-0">
                        <label for="session-id" class="form-text text-white">Session ID:</label>
                        <input type="number" name="session-id" class="form-control form-text" id="session-id-search" placeholder="Session ID" min="1">
                    </div>
                    <div class="col-auto py-2 px-4">
                        <label for="movie-title" class="form-text text-white">Title :</label>
                        <input type="text" name="movie-title" class="form-control form-text" id="movie-title-search" placeholder="Movie title">
                    </div>
                    <div class="col-auto py-2 px-4">
                        <label for="movie-genre" class="form-text text-white">Movie genre :</label>
                        <select name="movie-genre" class="form-control form-text" id="movie-genre-search">
                            <option value="all" selected>All</option>
                            <option value="action">Action</option>
                            <option value="adventure">Adventure</option>
                            <option value="animation">Animation</option>
                            <option value="biography">Biography</option>
                            <option value="comedy">Comedy</option>
                            <option value="crime">Crime</option>
                            <option value="drama">Drama</option>
                            <option value="family">Family</option>
                            <option value="fantasy">Fantasy</option>
                            <option value="horror">Horror</option>
                            <option value="mystery">Mystery</option>
                            <option value="romance">Romance</option>
                            <option value="sci-fi">Sci-Fi</option>
                            <option value="thriller">Thriller</option>
                        </select>
                    </div>
                    <div class="col-auto py-2 px-4">
                        <label for="pagination" class="form-text text-white">Number of results per page :</label>
                        <select name="pagination" class="form-control form-text" id="results-per-page">
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="30">30</option>
                            <option value="35">35</option>
                            <option value="40">40</option>
                            <option value="45">45</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class='card-body bg-secondary' id="result">
                <h2 class='text-white'>Movies watched - <span id="number-results"></h2>
                <table class='table table-bordered table-secondary table-striped table-hover'>
                    <thead>
                        <tr>
                            <th scope="col" width='65%'>Title</th>
                            <th scope="col" width='10%'>Genre</th>
                            <th scope="col" width='5%'>Room</th>
                            <th scope="col" width='10%'>Session date</th>
                            <th scope="col" width='10%'>Session hour</th>
                        </tr>
                    </thead>
                    <tbody id="post-data"></tbody>
                </table>
                <div class='row align-items-center' id="pagination-link"></div>
            </div>
        </div>
    </div>
</body>
<script src="../scripts/my_profile/profile_load.js"></script>
<script src="../scripts/my_profile/history/load.js"></script>
<script src="../scripts/my_profile/history/search.js"></script>

</html>