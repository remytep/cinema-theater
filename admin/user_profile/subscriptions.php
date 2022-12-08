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
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/popupform.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title id="page-title"></title>
</head>

<body class='bg-dark h-100'>
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
                                <a class="nav-link" id='user-personal-information'>Personal Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active text-dark" id='user-subscriptions'>Subscriptions</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="user-history">Movie History</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <form class='card-header row g-0 text-white justify-content-center' id='add-subscription'>
                <div class="py-2 px-4 d-flex justify-content-center">
                    <button class="popup-add-subscription btn text-white py-3 px-5 btn-success" id="popup-add-subscription-button">Add
                        subscription</button>
                </div>
            </form>
            <div class='card-body bg-secondary' id="result">
                <h3 class="text-center p-3">Subscription Information</h3>
                <h2 class='text-white'>Subscriptions - <span id="number-results"></h2>
                <table class='table table-bordered table-secondary table-striped table-hover'>
                    <thead>
                        <tr>
                            <th scope="col" width='15%'>Subscription name</th>
                            <th scope="col" width='30%'>Description</th>
                            <th scope="col" width='20%'>Start</th>
                            <th scope="col" width='20%'>End</th>
                            <th scope="col" width='7.5%'>Edit</th>
                            <th scope="col" width='7.5%'>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="post-data"></tbody>
                </table>
            </div>
        </div>
        <div id="popup-add-subscription" class='popup-add-subscription popup-form bg-dark p-5 rounded container-sm'>
            <h2 class='text-white py-2 popup-add-subscription'>Add a subscription</h2>
            <form class="row form">
                <div class="popup-add-subscription col py-2 px-4">
                    <label for="popup-add-subscription-type" class="popup-add-subscription form-label text-white">Subscription type :</label>
                    <select name="popup-add-subscription-type" class="popup-add-subscription form-control form-text" id="add-subscription-type">
                        <option selected default hidden class="popup-add-subscription">Select subscription type</option>
                        <option value="1" class="popup-add-subscription">VIP</option>
                        <option value="2" class="popup-add-subscription">GOLD</option>
                        <option value="3" class="popup-add-subscription">Classic</option>
                        <option value="4" class="popup-add-subscription">Pass Day</option>
                    </select>
                </div>
                <div class="popup-add-subscription col py-2 px-4">
                    <label for="popup-add-subscription-date" class="popup-add-subscription form-label text-white">Date :</label>
                    <input type="date" name="popup-add-subscription-date" value='2022-01-01' class="popup-add-subscription form-control form-text" id="add-subscription-date">
                </div>
                <div class="popup-add-subscription col py-2 px-4">
                    <label for="popup-add-subscription-time" class="popup-add-subscription form-label text-white">Time :</label>
                    <input type="time" step='1' name="popup-add-subscription-time" value='00:00:00' class="popup-add-subscription form-control form-text" id="add-subscription-time">
                </div>
                <div class="popup-add-subscription p-4 d-flex justify-content-center">
                    <button class="btn text-white py-2 px-4 btn-success" id="add-subscription-button">Add</button>
                </div>
            </form>
        </div>
        <div id="popup-edit-subscription" class='popup popup-form bg-dark p-5 rounded container-sm'>
            <h2 class='text-white py-2 popup'>Edit subscription</h2>
            <form class="row form">
                <div class="popup col py-2 px-4">
                    <label for="popup-edit-subscription-type" class="popup form-label text-white">Subscription type :</label>
                    <select name="popup-edit-subscription-type" class="popup form-control form-text" id="edit-subscription-type">
                        <option selected default hidden class="popup">Select subscription type</option>
                        <option value="1" class="popup">VIP</option>
                        <option value="2" class="popup">GOLD</option>
                        <option value="3" class="popup">Classic</option>
                        <option value="4" class="popup">Pass Day</option>
                    </select>
                </div>
                <div class="popup col py-2 px-4">
                    <label for="popup-edit-subscription-date" class="popup form-label text-white">Date :</label>
                    <input type="date" name="popup-edit-subscription-date" value='2022-01-01' class="popup form-control form-text" id="edit-subscription-date">
                </div>
                <div class="popup col py-2 px-4">
                    <label for="popup-edit-subscription-time" class="popup form-label text-white">Time :</label>
                    <input type="time" step='1' name="popup-edit-subscription-time" value='00:00:00' class="popup form-control form-text" id="edit-subscription-time">
                </div>
                <div class="popup-edit-subscription p-4 d-flex justify-content-center">
                    <button class="btn text-white py-2 px-4 btn-success" id="popup-edit-subscription-button">Edit</button>
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
<script src="../scripts/user_profile/profile_load.js"></script>
<script src="../scripts/user_profile/subscriptions/load.js"></script>
<script src="../scripts/user_profile/subscriptions/add.js"></script>
<script src="../scripts/user_profile/subscriptions/edit.js"></script>
<script src="../scripts/user_profile/subscriptions/delete.js"></script>

</html>