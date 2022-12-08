<?php
require_once('../../../../connection.php');

if (isset($_POST['membership-id'])) {
    $membershipId = $_POST["membership-id"];
    $sample_data = array(
        ':id'        =>    $membershipId,
    );
    $addQuery = "DELETE FROM membership WHERE id = :id";
    $statement = $conn->prepare($addQuery);
    $statement->execute($sample_data);
    echo 'successfully deleted';
}
