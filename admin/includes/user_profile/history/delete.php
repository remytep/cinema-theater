<?php
require_once('../../../../connection.php');

if (isset($_POST['log-id'])) {
    $logId = $_POST["log-id"];
    $sample_data = array(
        ':id'        =>    $logId,
    );
    $addQuery = "DELETE FROM user_log WHERE id = :id";
    $statement = $conn->prepare($addQuery);
    $statement->execute($sample_data);
}
