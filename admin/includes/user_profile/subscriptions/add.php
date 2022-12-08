<?php
require_once('../../../../connection.php');

if (isset($_POST['user-id']) && isset($_POST['subscription-type']) && isset($_POST['subscription-date']) && isset($_POST['subscription-time'])) {
    $userId = $_POST['user-id'];
    $subscriptionType = $_POST['subscription-type'];
    $subscriptionDate = $_POST['subscription-date'];
    $subscriptionTime = $_POST['subscription-time'];
    $sample_data = array(
        ':id'        =>    $userId,
        ':subscription'        =>    $subscriptionType,
        ':subscriptionDateTime'        =>    $subscriptionDate . ' ' . $subscriptionTime,
    );
    $addQuery = "INSERT INTO membership (id_user, id_subscription, date_begin) VALUES (:id, :subscription, :subscriptionDateTime)";
    $statement = $conn->prepare($addQuery);
    $statement->execute($sample_data);
    $result = $statement->fetch();
    echo 'Subscription added';
} else {
    echo 'Nothing happened';
}
