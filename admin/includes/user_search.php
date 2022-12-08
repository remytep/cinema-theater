<?php
require_once('../../connection.php');



// Formatte l'input en enlevant les caractères indésirables
function formatInput($input)
{
    $formatted = preg_replace('/[^A-Za-z0-9\- ]/', '', $input);
    $formatted = trim($formatted);
    return $formatted;
}


// Défintion des valeurs pour la pagination
$page = 1;
$limit = $_POST['results-per-page'];
if ($_POST["page"] > 1) {
    $start = (($_POST["page"] - 1) * $limit);

    $page = $_POST["page"];
} else {
    $start = 0;
}
if (isset($_POST['isMember'])) {
    $isMember = $_POST['isMember'];
    if ($isMember == 'true') {
        $baseQuery =
            "SELECT user.id, user.firstname, user.lastname, user.email, subscription.name, membership.date_begin, date_add(membership.date_begin, interval subscription.duration day)
        FROM membership
        INNER JOIN user ON user.id = membership.id_user
        INNER JOIN subscription ON subscription.id = membership.id_subscription
        ";
    } else {
        $baseQuery =
            "SELECT user.id, USER.firstname, USER.lastname, USER.email, subscription.name, membership.date_begin, date_add(membership.date_begin, interval subscription.duration day)
        FROM USER 
        LEFT JOIN membership ON USER.id = membership.id_user 
        LEFT JOIN subscription ON membership.id_subscription=subscription.id";
    }
}
// Execution de la requête SQL pour récupérer les résultats qui match l'input
if (isset($_POST['user-firstname']) && isset($_POST['user-lastname'])) {
    // Définition des variables pour plus de lisibilité
    $userFirstname = $_POST['user-firstname'];
    $userLastname = $_POST['user-lastname'];
    $data = array();
    if ($userFirstname != '' || $userLastname != '') {
        $sample_data = array(
            ':firstname'        =>    '%' . formatInput($userFirstname) . '%',
            ':lastname'        =>    '%' . formatInput($userLastname) . '%'
        );
        $query = $baseQuery . "
		    WHERE firstname LIKE :firstname
            AND lastname LIKE :lastname
            ORDER BY user.id ASC
		    ";
        $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit . '';
        $statement = $conn->prepare($query);
        $statement->execute($sample_data);
        $total_data = $statement->rowCount();
        $statement = $conn->prepare($filter_query);
        $statement->execute($sample_data);
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $data[] = array(
                'id'            =>    $row[0],
                'firstname'            =>    $row[1],
                'lastname'            =>    $row[2],
                'email'            =>    $row[3],
                'subscription'            =>    $row[4],
                'datebegin'            =>    $row[5],
                'dateend'            =>    $row[6],
            );
        }
    } else {
        // Cas de base (lors du page loading, aucun filtre ou d'un refresh)
        $query = $baseQuery . "
            ORDER BY user.id ASC
		    ";
        $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit . '';
        $statement = $conn->prepare($query);
        $statement->execute();
        $total_data = $statement->rowCount();
        $statement = $conn->prepare($filter_query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $data[] = array(
                'id'            =>    $row[0],
                'firstname'            =>    $row[1],
                'lastname'            =>    $row[2],
                'email'            =>    $row[3],
                'subscription'            =>    $row[4],
                'datebegin'            =>    $row[5],
                'dateend'            =>    $row[6],
            );
        }
    }
    // Pagination
    $pagination_html = '
<div align="center">
      <ul class="pagination justify-content-center">
';

    $total_links = ceil($total_data / $limit);
    if ($total_links == 0) {
        $data = [];
    } else {
        $previous_link = '';
        $next_link = '';
        $page_link = '';
        // Permet de gérer le nombre de liens générés en fonction du nombre de résultats
        if ($total_links > 4) {
            if ($page < 5) {
                for ($count = 1; $count <= 5; $count++) {
                    $page_array[] = $count;
                }
                $page_array[] = '...';
                $page_array[] = $total_links;
            } else {
                $end_limit = $total_links - 5;
                if ($page > $end_limit) {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for ($count = $end_limit; $count <= $total_links; $count++) {
                        $page_array[] = $count;
                    }
                } else {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for ($count = $page - 1; $count <= $page + 1; $count++) {
                        $page_array[] = $count;
                    }
                    $page_array[] = '...';
                    $page_array[] = $total_links;
                }
            }
        } else {
            for ($count = 1; $count <= $total_links; $count++) {
                $page_array[] = $count;
            }
        }
        // HTML à insérer
        for ($count = 0; $count < count($page_array); $count++) {
            if ($page == $page_array[$count]) {
                $page_link .= '
        <li class="page-item active">
              <a class="page-link" href="#">' . $page_array[$count] . ' <span class="sr-only">(current)</span></a>
        </li>
        ';
                $previous_id = $page_array[$count] - 1;
                if ($previous_id > 0) {
                    $previous_link = '<li class="page-item"><a class="page-link bg-dark text-white" href="javascript:userLoad(`' . $userFirstname . '`,`' . $userLastname  . '`, ' . $isMember . ' , ' . $previous_id . ')">Previous</a></li>';
                } else {
                    $previous_link = '
            <li class="page-item disabled">
                <a class="page-link bg-dark" href="#">Previous</a>
            </li>
            ';
                }
                $next_id = $page_array[$count] + 1;
                if ($next_id >= $total_links) {
                    $next_link = '
            <li class="page-item disabled">
                <a class="page-link bg-dark" href="#">Next</a>
              </li>
            ';
                } else {
                    $next_link = '
            <li class="page-item"><a class="page-link bg-dark text-white" href="javascript:userLoad(`' . $userFirstname . '`,`' . $userLastname  . '`, ' . $isMember . ' , ' . $next_id . ')">Next</a></li>
            ';
                }
            } else {
                if ($page_array[$count] == '...') {
                    $page_link .= '
            <li class="page-item disabled">
                  <a class="page-link bg-dark" href="#">...</a>
              </li>
            ';
                } else {
                    $page_link .= '
            <li class="page-item">
                <a class="page-link bg-dark text-white" href="javascript:userLoad(`' . $userFirstname . '`,`' . $userLastname  . '`, ' . $isMember . ' , ' . $page_array[$count] . ')">' . $page_array[$count] . '</a>
            </li>
            ';
                }
            }
        }

        $pagination_html .= $previous_link . $page_link . $next_link;
        $pagination_html .= '
    </ul>
</div>
';
    }
    $output = array(
        'data'                =>    $data,
        'pagination'        =>    $pagination_html,
        'total_data'        =>    $total_data
    );

    echo json_encode($output);
}
