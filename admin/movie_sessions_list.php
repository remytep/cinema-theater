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
    <link rel="stylesheet" href="./styles/popupform.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/movie_list_suggestion.css">
    <title>Movie Sessions</title>
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
                            <a class="nav-link" href="./movie_list.php">Movie List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active bg-white text-dark" href="./movie_sessions_list.php">Movie Sessions</a>
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
        <h1 class="text-center text-white p-5">Movie Sessions</h1>
        <div class="card bg-secondary">
            <div class="bg-secondary row g-0 d-flex">
                <h2 class="text-white p-4">Add a movie session</h2>
                <form autocomplete="off" class="card-header row g-0 text-white" id="movie-addsession">
                    <div class="col-2 py-2 px-4 ps-0">
                        <label for="movie-id-addsession" class="form-text text-white">Movie ID :</label>
                        <input type="number" name="movie-id-addsession" class="form-control form-text" id="movie-id-addsession" min="1" max="2413" required>
                    </div>
                    <div class="col-4 py-2 px-4 autocomplete ">
                        <label for="movie-title-addsession" class="form-text text-white">Movie Title :</label>
                        <div>
                            <input type="text" name="movie-title-addsession" class="form-control form-text" id="movie-title-addsession" required>
                        </div>
                    </div>
                    <div class="col-2 py-2 px-4">
                        <label for="movie-room-addsession" class="form-text text-white">Room number :</label>
                        <input type="number" name="movie-room-addsession" class="form-control form-text" id="movie-room-addsession" value="1" min="1" max="32" required>
                    </div>
                    <div class="col-2 py-2 px-4">
                        <label for="movie-sessionDate-addsession" class="form-text text-white">Session date
                            :</label>
                        <input type='date' name="movie-sessionDate-addsession" class="form-control form-text" id="movie-session-date-addsession" value="2018-01-01" min="2018-01-01">
                    </div>
                    <div class="col-2 py-2 px-4">
                        <label for="movie-sessionTime-addsession" class="form-text text-white">Session
                            time :</label>
                        <!--<input type='time' name="movie-sessionTime-addsession" class="form-control form-text"
                            id="movie-session-time-addsession" value="18:00" min="18:00" max="21:00" step="3600"> -->
                        <select name="movie-sessionTime-addsession" class="form-control form-text" id="movie-session-time-addsession">
                            <option value="18:00:00">18:00</option>
                            <option value="21:00:00">21:00</option>
                        </select>
                    </div>
                    <div class=" py-2 px-4 d-flex justify-content-center">
                        <button type="submit" class="btn text-white py-3 px-5 btn-success" id="add-movie-session">Add
                            movie
                            session</button>
                    </div>
                </form>
            </div>
            <form class='card-header row g-0 text-white'>
                <div class="col-auto py-2 px-4 ps-0">
                    <label for="session-id" class="form-text text-white">Session ID:</label>
                    <input type="number" name="session-id" class="form-control form-text" id="session-id-search" placeholder="Session ID" min="1">
                </div>
                <div class="col-auto py-2 px-4">
                    <label for="movie-title" class="form-text text-white">Title :</label>
                    <input type="text" name="movie-title" class="form-control form-text" id="movie-title-search" placeholder="Movie title">
                </div>
                <div class="col-auto py-2 px-4">
                    <label for="movie-session-search" class="form-text text-white">Session date :</label>
                    <input type='date' name="movie-session-search" class="form-control form-text" id="movie-session-date-search" value="2018-01-01" min="2018-01-01">
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
                <div class="form-text text-white p-2"><b>Total number of results - <span id="number-results"></span></b>
                </div>
            </form>
            <div class='card-body' id="result">
                <table class='table table-bordered table-secondary table-striped table-hover'>
                    <thead>
                        <tr>
                            <th scope="col" width='9%'>Session ID</th>
                            <th scope="col" width='8%'>Movie ID</th>
                            <th scope="col" width='40%'>Title</th>
                            <th scope="col" width='5%'>Genre</th>
                            <th scope="col" width='3%'>Room</th>
                            <th scope="col" width='10%'>Session date</th>
                            <th scope="col" width='10%'>Session hour</th>
                            <th scope="col" width='7.5%'>Edit</th>
                            <th scope="col" width='7.5%'>Delete</th>
                        </tr>
                    </thead>
                    <tbody class='align-middle' id="post-data">
                    </tbody>
                </table>
            </div>
            <div class='row align-items-center' id="pagination-link"></div>
        </div>
        <div id="popup-edit-moviesession" class='popup popup-form bg-dark p-5 rounded container-sm'>
            <h2 class='text-white py-2 popup'>Edit Movie Session</h2>
            <form class="row form">
                <div class="col-2 py-2 px-4">
                    <label for="popup-edit-moviesession-id" class="popup form-label text-white">Movie ID :</label>
                    <input type="number" name="popup-edit-moviesession-id" class="popup form-control form-text" id="popup-edit-moviesession-id" min="1" max="2413" required>
                </div>
                <div class="col-4 py-2 px-4 autocomplete">
                    <label for="popup-edit-moviesession-title" class="popup form-label text-white">Movie Title :</label>
                    <div>
                        <input type="text" name="popup-edit-moviesession-title" class="popup form-control form-text" id="popup-edit-moviesession-title" required>
                    </div>
                </div>
                <div class="col-2 py-2 px-4">
                    <label for="popup-edit-moviession-room" class="popup form-label text-white">Room number :</label>
                    <input type="number" name="popup-edit-moviession-room" class=" popup form-control form-text" id="popup-edit-moviesession-room" value="1" min="1" max="32" required>
                </div>
                <div class="popup col py-2 px-4">
                    <label for="popup-edit-moviesession-date" class="popup form-label text-white">Date :</label>
                    <input type="date" name="popup-edit-moviesession-date" value='2018-01-01' class="popup form-control form-text" id="popup-edit-moviesession-date">
                </div>
                <div class="popup col py-2 px-4">
                    <label for="popup-edit-moviesession-time" class="popup form-label text-white">Time :</label>
                    <input type="time" step='1' name="popup-edit-moviesession-time" value='00:00:00' class="popup form-control form-text" id="popup-edit-moviesession-time">
                </div>
                <div class="p-4 d-flex justify-content-center">
                    <button class="btn text-white py-2 px-4 btn-success" id="popup-edit-moviesession-button">Edit</button>
                </div>
            </form>
        </div>
        <div id='popup-delete' class='popup popup-form bg-dark p-5 rounded container-sm'>
            <h2 class='text-white py-2 popup text-center'>Do you really want to delete this session?</h2>
            <form class="row form">
                <div class="col p-4 d-flex justify-content-center">
                    <button class="btn text-white py-2 px-4 btn-success" id="delete-button-yes">Yes</button>
                </div>
                <div class="col p-4 d-flex justify-content-center">
                    <button class="btn text-white py-2 px-4 btn-success" id="delete-button-no">No</button>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="./scripts/movie_session/search.js"></script>
<script src="./scripts/movie_session/add.js"></script>
<script src="./scripts/movie_session/delete.js"></script>
<script src="./scripts/movie_session/edit.js"></script>
<script src="./scripts/movie_list_suggestion.js"></script>

</html>