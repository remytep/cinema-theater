<?php
require_once('../../../connection.php');

if (isset($_POST['movie-id-add']) && isset($_POST['movie-title-add']) && isset($_POST['movie-room-add']) && isset($_POST['movie-datebegin-add'])) {
    $movieIdAddSession = $_POST["movie-id-add"];
    $movieTitleAddSession = $_POST["movie-title-add"];
    $movieRoomAddSession = $_POST["movie-room-add"];
    $movieSchedulingDateBegin = $_POST["movie-datebegin-add"];

    $sample_data = array(
        ':id'        =>    $movieIdAddSession,
        ':room'        =>    $movieRoomAddSession,
        ':scheduling'        =>    $movieSchedulingDateBegin
    );
    $addQuery = "INSERT INTO movie_schedule (id_movie, id_room, date_begin) VALUES (:id, :room, :scheduling)";
    $statement = $conn->prepare($addQuery);
    $statement->execute($sample_data);
}
