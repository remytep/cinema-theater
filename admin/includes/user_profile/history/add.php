<?php
require_once('../../../../connection.php');


if (isset($_POST['user-id']) && isset($_POST['session-id-add'])) {
    $sessionId = $_POST["session-id-add"];
    $userId = $_POST['user-id'];
    $checkQuery = 'SELECT EXISTS(SELECT * FROM movie_schedule WHERE movie_schedule.id LIKE :sessionId)';
    $sample_data = array(
        ':sessionId'        =>    $sessionId
    );
    $statement = $conn->prepare($checkQuery);
    $statement->execute($sample_data);
    $result = $statement->fetch();
    if ($result[0] != '0') {
        $sample_data = array(
            ':userId'        =>    $userId,
            ':sessionId'        =>    $sessionId
        );
        $addQuery = "INSERT INTO user_log (id_user, id_session) VALUES (:userId, :sessionId)";
        $statement = $conn->prepare($addQuery);
        $statement->execute($sample_data);
        echo 'success';
    }
}
