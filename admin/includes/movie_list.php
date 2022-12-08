<?php
require_once('../../connection.php');


// Execution de la requête SQL pour récupérer les résultats qui match l'input
$data = array();
// Cas où un genre est séléctionné
$query = "
SELECT title
FROM movie 
ORDER BY id ASC
";
$statement = $conn->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach ($result as $row) {
    $data[] = array(
        'title'            =>    $row[0],
    );
}
echo json_encode($data);
