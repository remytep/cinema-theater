<?php
require_once('../../../../connection.php');
session_start();
$checkQuery = "SELECT EXISTS(SELECT * FROM employee WHERE id_user LIKE :id)";

if (isset($_SESSION['id_user'])) {
    $userId = $_SESSION['id_user'];
    $sample_data = array(
        ':id'        =>    $userId
    );
    $statement = $conn->prepare($checkQuery);
    $statement->execute($sample_data);
    $result = $statement->fetch();
    if ($result[0] == '0') {
        echo json_encode('None');
    } else {
        $staffQuery =
            "SELECT job.name, job.executive ,job.description, job.salary, DATE(employee.date_begin)
            FROM employee INNER JOIN job ON job.id=employee.id_job 
            WHERE employee.id_user LIKE :id";
        $statement = $conn->prepare($staffQuery);
        $statement->execute($sample_data);
        $result = $statement->fetch();
        $data[] = array(
            'jobName'            =>    $result[0],
            'executive'            =>    $result[1],
            'jobDescription'            =>    $result[2],
            'jobSalary'            =>    $result[3],
            'dateBegin'            =>    $result[4],
        );
        echo json_encode($data);
    }
}
