<?php
require_once('../../../connection.php');

if (isset($_POST['user-id'])) {
    $userId = $_POST['user-id'];
    $query = "SELECT firstname, lastname, email, 
    DATE(birthdate), address, zipcode, city, 
    country, subscription.name, 
    membership.date_begin, date_add(membership.date_begin, interval subscription.duration day)
    FROM user
    LEFT JOIN membership ON USER.id = membership.id_user 
    LEFT JOIN subscription ON membership.id_subscription=subscription.id
    WHERE user.id LIKE :id";
    $sample_data = array(
        ':id'        =>    $userId
    );
    $statement = $conn->prepare($query);
    $statement->execute($sample_data);
    $result = $statement->fetch();
    $data[] = array(
        'firstname'            =>    $result[0],
        'lastname'            =>    $result[1],
        'email'            =>    $result[2],
        'birthDate'            =>    $result[3],
        'address'            =>    $result[4],
        'zipcode'            =>    $result[5],
        'city'            =>    $result[6],
        'country'            =>    $result[7],
        'subscription'            =>    $result[8],
        'datebegin'            =>    $result[9],
        'dateend'            =>    $result[10],
    );
    echo json_encode($data);
}
