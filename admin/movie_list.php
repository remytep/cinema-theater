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
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Movie Search</title>
</head>

<body class='bg-dark'>
    <header>
        <nav class="nav nav-pills navbar navbar-expand-lg navbar-dark bg-dark py-2">
            <div class="container-fluid">
                <a class="navbar-brand" href="./">MyCinema Admin Panel</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active bg-white text-dark" href="./movie_list.php">Movie List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./movie_sessions_list.php">Movie Sessions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./user_list.php">User List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./staff_list.php">Staff List</a>
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
        <h1 class="text-center text-white p-5">Movie List</h1>
        <div class="card bg-secondary">
            <form class='card-header row g-0 text-white' id='movie-search' action="post">
                <div class="col-auto py-2 px-4 ps-0">
                    <label for="movie-title" class="form-label text-white">Title :</label>
                    <input type="text" name="movie-title" class="form-control form-text" id="movie-title-search" placeholder="Movie title">
                </div>
                <div class="col-auto py-2 px-4">
                    <label for="movie-distributor" class="form-label text-white">Distributor :</label>
                    <input type="text" name="movie-distributor" class="form-control form-text" id="movie-distributor-search" placeholder="Distributor name">
                </div>
                <div class="col-auto py-2 px-4">
                    <label for="movie-genre" class="form-label text-white">Movie genre :</label>
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
                    <label for="pagination" class="form-label text-white">Number of results per page :</label>
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
                <div class="form-text text-white p-2"><b>Total number of results - <span id="number-results"></span></b>
                </div>
            </form>
            <div class='card-body' id="result">
                <table class='table table-bordered table-secondary table-striped table-hover'>
                    <thead>
                        <tr>
                            <th scope="col" width='5%'>ID</th>
                            <th scope="col" width='30%'>Title</th>
                            <th scope="col" width='20%'>Director</th>
                            <th scope="col" width='20%'>Distributor</th>
                            <th scope="col" width='10%'>Genre</th>
                            <th scope="col" width='10%'>Duration</th>
                            <th scope="col" width='5%'>Rating</th>
                        </tr>
                    </thead>
                    <tbody id="post-data"></tbody>
                </table>
            </div>
            <div class='row align-items-center' id="pagination-link"></div>
        </div>
    </div>
    <script src="./scripts/movie_search.js"></script>
</body>

</html>