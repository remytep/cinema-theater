<?php
require_once('../../../connection.php');

if (isset($_POST['session-id']) && isset($_POST['moviesession-movieid']) && isset($_POST['moviesession-room']) && isset($_POST['moviesession-date']) && isset($_POST['moviesession-time'])) {
    $sessionId = $_POST['session-id'];
    $movieSessionId = $_POST['moviesession-movieid'];
    $movieSessionRoom = $_POST['moviesession-room'];
    $movieSessionDate = $_POST['moviesession-date'];
    $movieSessionTime = $_POST['moviesession-time'];
    $sample_data = array(
        ':id'        =>    $sessionId,
        ':movieId'        =>    $movieSessionId,
        ':movieSessionRoom'        =>    $movieSessionRoom,
        ':sessionDateTime'        =>    $movieSessionDate . ' ' . $movieSessionTime,
    );
    $updateQuery = "UPDATE movie_schedule SET id_movie=:movieId, id_room=:movieSessionRoom, date_begin=:sessionDateTime WHERE id LIKE :id";
    $statement = $conn->prepare($updateQuery);
    $statement->execute($sample_data);
    $result = $statement->fetch();
    echo 'Success';
} else {
    echo 'Nothing happened';
}
