<?php
require_once('../../../connection.php');

if (isset($_POST['session-id'])) {
    $sessionId = $_POST["session-id"];
    $sample_data = array(
        ':id'        =>    $sessionId,
    );
    $addQuery = "DELETE FROM movie_schedule WHERE id = :id";
    $statement = $conn->prepare($addQuery);
    $statement->execute($sample_data);
}
