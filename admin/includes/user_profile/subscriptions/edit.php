<?php
require_once('../../../../connection.php');
if (isset($_POST['subscription-id']) && isset($_POST['subscription-type']) && isset($_POST['subscription-date']) && isset($_POST['subscription-time'])) {
    $subscriptionId = $_POST['subscription-id'];
    $subscriptionType = $_POST['subscription-type'];
    $subscriptionDate = $_POST['subscription-date'];
    $subscriptionTime = $_POST['subscription-time'];
    $sample_data = array(
        ':id'        =>    $subscriptionId,
        ':subscription'        =>    $subscriptionType,
        ':subscriptionDateTime'        =>    $subscriptionDate . ' ' . $subscriptionTime,
    );
    $updateQuery = "UPDATE membership SET id_subscription=:subscription, date_begin=:subscriptionDateTime WHERE id LIKE :id";
    $statement = $conn->prepare($updateQuery);
    $statement->execute($sample_data);
    $result = $statement->fetch();
    echo 'Success';
} else {
    echo 'Nothing happened';
}
