<?php
require_once('../../../../connection.php');

if (isset($_POST['user-id'])) {
    $userId = $_POST['user-id'];
    $query = "SELECT subscription.name, subscription.description, 
    membership.date_begin, date_add(membership.date_begin, interval subscription.duration day), membership.id
    FROM user
    LEFT JOIN membership ON USER.id = membership.id_user 
    LEFT JOIN subscription ON membership.id_subscription=subscription.id
    WHERE user.id LIKE :id";
    $sample_data = array(
        ':id'        =>    $userId
    );
    $data = [];
    $statement = $conn->prepare($query);
    $statement->execute($sample_data);
    $total_data = $statement->rowCount();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        if ($row[0] != NULL) {
            $data[] = array(
                'subscriptionName'            =>    $row[0],
                'subscriptionDescription'            =>    $row[1],
                'datebegin'            =>    $row[2],
                'dateend'            =>    $row[3],
                'membershipId'            =>    $row[4],
            );
        } else {
            $total_data--;
        }
    }
    $output = array(
        'data'        =>    $data,
        'total_data'        =>    $total_data,
    );
    echo json_encode($output);
}
